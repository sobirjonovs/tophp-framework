# tophp-framework

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://github.com/sobirjonovs/tophp-framework) TOPHP - o'zbekcha sodda freymvork

# Start local web server
```sh
php do server
```
# Write custom routes (project_folder/routes/web.php)
```sh
<?php

use App\Controllers\HomeController;

// Adding wildcard with colon character
$route->get('user/:id', function($id) {
    echo $id;
});

$route->get('/', [HomeController::class, 'index']);
```

# Available database accessor (model) methods
| Method | Description |
| ------ | ------ |
| create(array $data) | Inserts the values into database |
| all() | Gets whole data from the table |
| where(array $condition) | Gets data conditionally from table |
| other methods: find(), update(), get() and etc... | Not completed |
