import "flatpickr/dist/flatpickr.css";

import flatpickr from "flatpickr";
import {Modal} from "bootstrap";

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

iziToast.settings({
    timeout: 3000,
    resetOnHover: true,
    position: 'topRight',
});

// SweetAlert2 default configuration
const SwalConfirm = Swal.mixin({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, do it!"
});

const Toast = {
    show(type, title, message) {
        try {
            iziToast[type]({
                title,
                message,
            });
        } catch (e) {
            console.log("Error displaying toast:", e);
        }
    },
    success(message){
        this.show("success", "Success", message);
    },
    error(message){
        this.show("error", "Error", message);
    }
}

const TaskStatus = {
    PENDING: 'pending',
    IN_PROGRESS: 'in-progress',
    COMPLETED: 'completed',
}

const TaskStatusLabel = {
    PENDING: 'Pending',
    IN_PROGRESS: 'In Progress',
    COMPLETED: 'Completed',
}

const TaskStatusValues = {
    [TaskStatus.PENDING]: TaskStatusLabel.PENDING.toLowerCase(),
    [TaskStatus.IN_PROGRESS]: TaskStatusLabel.IN_PROGRESS.toLowerCase(),
    [TaskStatus.COMPLETED]: TaskStatusLabel.COMPLETED.toLowerCase(),
}

const Ajax = {
    request (url, method = 'GET', data = {}, successCallback, errorCallback) {
        $.ajax({
            url: url,
            type: method,
            data: data || {},
            success: (response) => {
                successCallback(response);
            },
            error: (error) => {
                console.error(error);
                if (errorCallback) {
                    errorCallback(error);
                    return;
                }

                Ajax.errorCallback(error);
            }
        });
    },
    errorCallback (error) {
        if (error.message) {
            Toast.error(error.message);
            return;
        }
        Toast.error("Something went wrong during server request.");
    },
    put(url, data, successCallback, errorCallback) {
        Ajax.request(url, 'PUT', data, successCallback, errorCallback);
    },
    post(url, data, successCallback, errorCallback) {
        Ajax.request(url, 'POST', data, successCallback, errorCallback);
    },
    delete(url, data, successCallback, errorCallback) {
        Ajax.request(url, 'DELETE', data, successCallback, errorCallback);
    }
}

// Debounce function to limit the rate of function calls
const debounce = (func, delay) => {
    let timeoutId;
    return function(...args) {
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        timeoutId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    }
}

const App = {
    // server requests
    async getTasks(status, sortBy) {
        try {
            sortBy = sortBy || '';

            if (!status || status === 'all') {
                return await $.get(`/task?sort=${sortBy}`);
            }

            status = TaskStatusValues[status] || status;

            return await $.get(`/task?status=${status}&sort=${sortBy}`);
        } catch (error) {
            console.error("Error fetching tasks:", error);
            if(error.message) {
                Toast.error(error.message);
                return;
            }
            Toast.error("Failed to fetch data. Please try again later.");
            throw error;
        }
    },
    async getTask(taskId) {
        if (!taskId) {
            throw new Error("Task ID is required to fetch task details.");
        }

        const response = await $.get(`/task/${taskId}`);
        if (response.success) {
            return response.data;
        }
        Toast.error(response.message || "Failed to fetch task details.");

        return null;
    },
    updateTaskStatus(taskId, status, render = true) {
        Ajax.put(`/task/${taskId}/update-status`, {status}, async function (response) {
            if (response.success) {
                await App.onSuccess(response, render);
            } else {
                Toast.error(response.message);
            }
        });
    },
    addTask(formData, formEl, callback) {
        const formDataObj = Object.fromEntries(formData.map(item => [item.name, item.value]));
        Ajax.post(`/task`, formData, async function (response) {
            const render = formDataObj.kanban == 1 ? false : true;
            if (response.success) {
                if (!render) {
                    dispatchEvent(new CustomEvent('update-kanban', {
                        detail: {
                            task: response.data,
                            status: formDataObj.status
                        }
                    }));
                }
                await App.onSuccess(response, render);
                App.resetForm(formEl);
                callback();
            } else {
                Toast.error(response.message);
            }
        }, function (error) {
            if (error.responseJSON) {
                const errorObj = error.responseJSON;
                const formErrors = errorObj.errors || {};
                App.showFormErrors(formErrors, formEl);
                Toast.error("Please fill all required fields correctly.");
                return;
            }
            Toast.error("Something went wrong while adding the task.");

            throw error;
        })
    },
    updateTask(formData, formEl, callback) {
        const formDataObj = Object.fromEntries(formData.map(item => [item.name, item.value]));
        Ajax.put(formEl.action, formData, async function (response) {
            const render = formDataObj.kanban == 1 ? false : true;
            if (response.success) {
                if (!render) {
                    dispatchEvent(new CustomEvent('update-task-card', {
                        detail: {
                            task: response.data,
                            status: formDataObj.status
                        }
                    }));
                }
                await App.onSuccess(response, render);
                App.resetForm(formEl);
                callback();
            } else {
                Toast.error(response.message);
            }
        }, function (error) {
            if (error.responseJSON) {
                const errorObj = error.responseJSON;
                const formErrors = errorObj.errors || {};
                App.showFormErrors(formErrors, formEl);
                Toast.error("Please fill all required fields correctly.");
                return;
            }
            Toast.error("Something went wrong while adding the task.");

            throw error;
        })
    },
    async deleteTask(taskId, render = true) {
        return new Promise((resolve, reject) => {
            Ajax.delete(`/task/${taskId}`, {}, async function (response) {
                if (response.success) {
                    if (!render) {
                        dispatchEvent(new CustomEvent('delete-task-card', {
                            detail: { taskId }
                        }));
                    }
                    await App.onSuccess(response, render);
                    resolve(response);
                } else {
                    Toast.error(response.message);
                    reject(response);
                }
            }, function (error) {
                Toast.error("Something went wrong while deleting the task.");
                reject(error);
            });
        });
    },
    async searchTasks(status, keyword, sortBy) {
        status = TaskStatusValues[status] || status;
        keyword = encodeURIComponent(keyword);
        sortBy = sortBy || '';

        try {
            if (!status || status === 'all') {
                return await $.get(`/task?keyword=${keyword}&sort=${sortBy}`);
            }
            return await $.get(`/task?status=${status}&keyword=${keyword}&sort=${sortBy}`);
        } catch (error) {
            console.error("Error during search:", error);
            Toast.error("Failed to fetch tasks. Please try again later.");
        }

    },

    // helper functions
    initDatepicker(element) {
        flatpickr(element, {
            enableTime: false,
            dateFormat: "Y-m-d",
            allowInput: false,
            clickOpens: true,
            altInput: true,
            altFormat: "F j, Y",
        })
    },
    resetForm(formEl) {
        this.removeFormErrors(formEl);
        formEl.reset();
    },
    removeFormErrors(formEl) {
        $(formEl).find('.error-message').remove();
        $(formEl).find('.invalid-feedback').remove();
        $(formEl).find('.is-invalid').removeClass('is-invalid');
    },
    showFormErrors(formErrors, formEl) {
        const $form = $(formEl);
        this.removeFormErrors(formEl);
        for (const [field, errors] of Object.entries(formErrors)) {
            const $input = $form.find(`[name="${field}"]`);
            if ($input.length) {
                $input.addClass('is-invalid');
                const errorHtml = `<div class="invalid-feedback">${errors.join(', ')}</div>`;
                $input.after(errorHtml);
            }
        }
        $form.find('.datepicker').each((_, el) => {
            const $elem = $(el);
            if ($elem.hasClass('is-invalid')) {
                $elem.removeClass('is-invalid');
                $elem.next('.invalid-feedback').remove();
            }
        });
        $form.find('.datepicker.flatpickr-input').each((_, el) => {
            const errors = formErrors[el.name] || [];
            $(el).next('.border-danger');
            $(el).parent().append(
                `<div class="small error-message text-danger">${errors.join(', ')}</div>`
            );
        });
    },
    async onSuccess(response, render = true) {
        Toast.success(response.message);
        if (render) {
            await App.renderTaskList(App.getActiveTab());
        }
    },
    getTaskContainer(status) {
        return $(`#task-${status}`);
    },
    getLoadingSpinner() {
        return `<div class="text-center d-flex flex-column align-items-center gap-2 py-4">
            <div class="spinner-border" role="status"></div>
            <span class="sr-only fs-5">Fetching Tasks...</span>
        </div>`;
    },
    getActiveTab() {
        const activeTab = $('#task-tab .nav-link.active');
        if (activeTab.length) {
            return activeTab.data('task-status');
        }
        return null;
    },
    async renderTaskOnSearch(status, keyword) {
        const taskContainer = App.getTaskContainer(status);
        const loadingSpinner = App.getLoadingSpinner();
        taskContainer.html(loadingSpinner);

        const taskListHtml = await App.searchTasks(status, keyword);
        taskContainer.html(taskListHtml);
    },
    async renderTaskList(status, sortBy) {
        const taskContainer = App.getTaskContainer(status);
        const loadingSpinner = App.getLoadingSpinner();
        taskContainer.html(loadingSpinner);

        let taskListHtml = null;

        sortBy = sortBy || $('#sortBy').val();
        const keyword = $('#search').val().trim();
        if (keyword && keyword.length > 0) {
            taskListHtml = await App.searchTasks(status, keyword, sortBy);
        } else {
            taskListHtml = await App.getTasks(status, sortBy);
        }

        taskContainer.html(taskListHtml);
    },
    confirmAlert(message, callback, confirmCallback) {
        SwalConfirm.fire({
            text: message,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise(async (resolve) => {
                    await callback();
                    resolve();
                });
            }
        }).then((result) => {
            if (result.isConfirmed && confirmCallback) {
                confirmCallback();
            }
        }).catch((error) => {
            console.error("Error in confirmation:", error);
            Toast.error("Something went wrong during confirmation.");
        })
    },
    setFormValues(data, formEl) {
        Object.entries(data).map(([key, value]) => {
            const $input = $(formEl).find(`[name="${key}"]`);
            if ($input) {
                $input.val(value);
                if ($input.hasClass('datepicker')) {
                    const instance = $input[0]._flatpickr
                    if (instance) {
                        instance.setDate(value, true);
                    } else {
                        App.initDatepicker($input[0]);
                    }
                }
            }
        });
    },
    async openEditTaskModal(taskId, formId, modalId) {
        const task = await App.getTask(taskId);
        if (task) {
            const { id, created_at, updated_at, ...taskData } = task;
            this.setFormValues(taskData, formId);
            $(formId).attr('action', `/task/${id}`);
            Modal.getOrCreateInstance(modalId).show();
        }
    }
}

window.iziToast = iziToast;
window.Swal = Swal;
window.TaskStatus = TaskStatus;
window.TaskStatusLabel = TaskStatusLabel;
window.TaskStatusValues = TaskStatusValues;
window.Toast = Toast;
window.SwalConfirm = SwalConfirm;
window.debounce = debounce;
window.Ajax = Ajax;
window.App = App;

$(document).ready(() => {
    // Initialize the task list on the page load
    (async () => {
        if (App.getActiveTab()) {
            await App.renderTaskList(TaskStatus.PENDING);
        }
    })()

    const taskTabs = Object.values(TaskStatus);

    // Fetch task data on status tab change
    taskTabs.forEach(tab => {
        $(document).on('click', `#task-${tab}-tab`, async () => {
            await App.renderTaskList(tab);
        });
    });
    $(document).on('click', `#task-all-tab`, async () => {
        await App.renderTaskList('all');
    });

    // Search task status on change
    $(document).on('keyup', '#search', debounce(async function (e) {
        const $el = $(e.target);
        const taskStatus = App.getActiveTab();
        await App.renderTaskOnSearch(taskStatus, $el.val());
    }, 300));

    // Get sorted task list on sorting change
    $(document).on('change', '#sortBy', async function (e) {
        const $el = $(e.target);
        const taskStatus = App.getActiveTab();
        await App.renderTaskList(taskStatus, $el.val());
    });

    // Update task status on change
    $(document).on('change', '.update-status', function (e) {
        const $el = $(e.target);
        const taskId = $el.data('task-id');
        App.updateTaskStatus(taskId, $el.val());
    });

    // clear search input
    $(document).on('click', '#clearButton', async function (e) {
        $('#search').val('').trigger('keyup');
    });

    // Open edit task modal
    $(document).on('click', '.edit-task', async function (e) {
        const $el = $(e.currentTarget);
        const taskId = $el.data('task-id');
        await App.openEditTaskModal(taskId, "#formUpdateTask", "#editTaskModal");
    });

    // delete task
    $(document).on('click', '.delete-task', function (e) {
        const $el = $(e.currentTarget);
        const taskId = $el.data('task-id');
        App.confirmAlert('Are you sure you want to delete this task?', async () => {
            const isKanban = $el.data('kanban') == 1;
            await App.deleteTask(taskId, !isKanban);
        });
    });

    // Add task form submission
    $(document).on('submit', '#formAddTask', function (e) {
        e.preventDefault();
        const $form = $(e.target);
        const formData = $form.serializeArray();

        App.addTask(formData, $form[0], function () {
            Modal.getOrCreateInstance('#addTaskModal').hide();
        });
    });

    // Update task form submission
    $(document).on('submit', '#formUpdateTask', function (e) {
        e.preventDefault();
        const $form = $(e.target);
        const formData = $form.serializeArray();

        App.updateTask(formData, $form[0], function () {
            Modal.getOrCreateInstance('#editTaskModal').hide();
        });
    });

    // Initialize flatpickr for date inputs
    App.initDatepicker(".datepicker");

});
