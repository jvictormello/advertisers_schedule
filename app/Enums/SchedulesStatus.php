<?php

namespace App\Enums;

enum SchedulesStatus: string
{
    case Pending = "Pendente";
    case InProgress = "Em Andamento";
    case Finished = "Finalizado";
}