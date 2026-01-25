<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{
    public int $maxAttempts   = 5;    // maksimal percobaan
    public int $lockoutMinute = 2;    // durasi lock (menit)
}
