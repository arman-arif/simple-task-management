import 'jquery-ui/dist/jquery-ui';
import 'jquery-ui/dist/themes/base/jquery-ui.css'
import dayjs from "dayjs";
import RelativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(RelativeTime)

$(document).ready(function () {

    function addCard(board, cardContent) {
        $(board).prepend(cardContent);
        updateEmptyBoard(board);
    }

    function updateEmptyBoard(board) {
        if($(board).children().length > 0) {
            $(board).find('.not-available').remove();
        }
    }

    function updateCard(card, board) {
        const taskId = card.data('task-id');
        const taskStatus = board.data('task-status');
        const status = TaskStatusValues[taskStatus];
        App.updateTaskStatus(taskId, status, false);
    }

    function updateOldContainer(oldContainer) {
        setTimeout(() => {
            const $container = $(`#${oldContainer[0].id}`);
            if($container.children().length === 0) {
                $container.append('<div class="text-center not-available py-4">No tasks available</div>');
            }
        }, 100);
    }

    function makeElementDraggable(element) {
        $(element).draggable({
            cancel: ".task-content",
            containment: 'document',
            revert: "invalid",
            helper: "clone",
            cursor: "move"
        });
    }

    makeElementDraggable('.kanban-board .kanban-card');

    $( '.kanban-board .kanan-card-container' ).droppable({
        accept: ".kanban-card",
        drop: function( event, ui ) {
            const card = ui.draggable;
            const oldContainer = card.parent('.kanan-card-container');
            const currentContainer = $(this);
            if (oldContainer.data('task-status') === currentContainer.data('task-status')) {
                return; // No change in status, do nothing
            }
            addCard(currentContainer, card);
            updateCard(card, currentContainer);
            updateOldContainer(oldContainer);
        }
    });

    $(window).on('update-kanban', function ({detail}) {
        const statusSlug = detail.status.replaceAll(' ', '-');
        const taskContainer = $(`#${statusSlug}-card-container`);
        const $taskCard = taskCard(detail.task);
        taskContainer.prepend($taskCard);
        makeElementDraggable($taskCard);
        updateEmptyBoard(taskContainer);
    });

    $(window).on('update-task-card', function ({detail}) {
        const statusSlug = detail.status.replaceAll(' ', '-');
        const taskContainer = $(`#${statusSlug}-card-container`);
        const $taskCard = taskCard(detail.task);
        const existingCard = $(`.kanban-card[data-task-id="${detail.task.id}"]`);
        const oldContainer = existingCard.parent('.kanan-card-container');
        existingCard.remove();
        taskContainer.prepend($taskCard);
        makeElementDraggable($taskCard);
        updateEmptyBoard(taskContainer);
        updateOldContainer(oldContainer);
    });

    $(window).on('delete-task-card', function ({detail}) {
        const existingTask = $(`.kanban-card[data-task-id="${detail.taskId}"]`);
        const oldContainer = existingTask.parent('.kanan-card-container');
        existingTask.remove();
        updateOldContainer(oldContainer);
    });

    function taskCard(task) {
        return $(`
            <div class="card kanban-card" data-task-id="${task.id}">
                <div class="card-header d-flex align-items-center">
                    <h6 class="mb-0 fw-bold">${task.title}</h6>
                </div>
                <div class="card-body">
                    <div class="task-content">
                        ${ task.description ?? 'No description provided.' }

                        <div class="d-flex justify-content-between flex-column mt-3">
                            <div class="text-muted small">
                                Created: ${dayjs(task.created_at).fromNow()}
                            </div>
                            <div class="text-muted small">
                                Updated: ${dayjs(task.updated_at).fromNow()}
                            </div>
                            <div class="text-muted small">
                                Due on: ${dayjs(task.due_date).format("ddd, DD MMM YYYY")}
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-sm btn-secondary edit-task" data-task-id="${task.id}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-task" data-task-id="${task.id}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `)
    }

});
