<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Delivered = 'delivered';

    case Sent = 'sent';

    case Accepted = 'accepted';

    case Processing = 'processing';

    case Canceled = 'canceled';
}
