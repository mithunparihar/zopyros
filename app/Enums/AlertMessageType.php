<?php

namespace App\Enums;

enum AlertMessageType: string
{
    case SAVE = "Saved!";
    case SORRY = "Sorry!";
    case UPDATE = "Updated!";
    case REMOVE = "Remove!";
    case DONE = "Done!";
}
