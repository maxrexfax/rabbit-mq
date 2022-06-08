# Instructions
**1 Start docker container with RabbitMQ**
```sh
docker-compose up -d
```

**2 Start consumers** - for one type of tomato it is file receive.php, for all types of receiveAll.php
This is necessary for creating exchange, queue and binding.

**3 Make sending random tomatoes** objects using send_objects.php

File receive.php can be used with arguments "red", "green", "yellow"
examples:
```sh
php receive.php yellow
php receive.php red
php receive.php green
```

File receiveAll.php must be used with argument "#"
example:
```sh
php receiveAll.php "#"
```

File send_objects.php can be used without arguments, 
or can be set number AND color of objects to send
example:
send 5 with random color (default)
```sh
php send_objects.php
```

send 24
```sh
php send_objects.php 24
```


send 24 with blue color
```sh
php send_objects.php 24 blue
```
Colors
-red
-green
-yellow
-blue