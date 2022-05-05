# php-config

Небольшой класс, предназначенный для считывания и записи конфигов. Все конфиги должны храниться в одной папке в .json формате. Класс учитывает вложенность объектов.

## Использование:

Для идентификации каталога с конфигами нужно вызвать функцию:
```php
 config::setPath("path_to_configs_dir"); 
```


### Получение 1 параметра
```php
$parameter = config::get("config_name")->value("name");
```

### Получение нескольких параметров
```php
$parameter = config::get("config_name")->values("name","surname","age");
```

### Получение всего конфига
```php
$parameter = config::get("config_name")->values();
```

### Получение всего конфига за исключением
```php
$parameter = config::get("config_name")->exclude("age");
```

### Изменить данные конфига
```php
$parameter = config::get("config_name")->update(["age" => 12]);
$parameter = config::get("config_name")->update(["age" => ["born" => 12]]); ## значение age.born может быть только типа int и не будет обновлено при передаче другого типа
```
