<?php

namespace App\Enums;

use Spatie\Html\BaseElement;
use Spatie\Html\Elements\Span;

enum TaskStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in progress';
    case Completed = 'completed';

    public function is($status): bool
    {
        return $this->value === $status;
    }

    public function isPending(): bool
    {
        return $this->is(self::Pending);
    }


    public function label(): string
    {
        return str($this->value)->title();
    }

    public function html(): BaseElement|Span
    {
        return html()->span($this->label())
            ->class($this->className());
    }

    public function className(): string
    {
        return match ($this) {
            self::Pending => 'badge bg-warning',
            self::Completed => 'badge bg-success',
            default => 'badge bg-info',
        };
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = self::from($case->value)->label();
        }
        return $options;
    }

}
