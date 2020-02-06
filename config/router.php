<?php
return array(
    '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)/([0-9]++)/p([0-9]++)' => '$controller/$action/$id/$page',
    '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)/p([0-9]++)' => '$controller/$action/$page',
    '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)/([0-9]++)' => '$controller/$action/$id',
    '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)' => '$controller/$action',
    '([a-z0-9+_\-]+)(/)?' => '$controller',
    );