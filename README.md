# DatabaseHandler Class Documentation

The `DatabaseHandler` class provides a secure and easy-to-use interface for interacting with a MySQL database in PHP. It handles database connections, CRUD (Create, Read, Update, Delete) operations, data sanitization, and basic data validation.

## Constructor

### `__construct($host, $username, $password, $database)`

- **Description:** Initializes a new `DatabaseHandler` object and establishes a connection to the MySQL database.
- **Parameters:**
  - `$host`: The hostname of the database server.
  - `$username`: The username used to connect to the database.
  - `$password`: The password used to connect to the database.
  - `$database`: The name of the database to connect to.
- **Returns:** None.

## Methods

### `insertData($table, $data)`

- **Description:** Inserts data into the specified table in the database.
- **Parameters:**
  - `$table`: The name of the table where the data will be inserted.
  - `$data`: An associative array containing the column names and values to be inserted.
- **Returns:** `true` if the data is successfully inserted, otherwise returns an error message string.

**Example:**

```php
$db = new DatabaseHandler("localhost", "username", "password", "database");

$data = array(
    "name" => "John",
    "email" => "john@example.com"
);

$result = $db->insertData("users", $data);
if ($result === true) {
    echo "Data inserted successfully.";
} else {
    echo "Error: " . $result;
}

```

## `readData($table, $conditions = "")`

**Description:** Reads data from the specified table in the database.

**Parameters:**
- `$table`: The name of the table from which data will be read.
- `$conditions` (optional): Additional conditions to filter the data (e.g., WHERE clause).

**Returns:** An array containing the retrieved data as associative arrays, or an error message string if an error occurs.

**Example:**

```php
$db = new DatabaseHandler("localhost", "username", "password", "database");

$users = $db->readData("users");
if (!is_string($users)) {
    foreach ($users as $user) {
        echo "Name: " . $user['name'] . ", Email: " . $user['email'] . "<br>";
    }
} else {
    echo "Error: " . $users;
}
```


## `readData($table, $conditions = "")`

**Description:** Reads data from the specified table in the database.

**Parameters:**
- `$table`: The name of the table from which data will be read.
- `$conditions` (optional): Additional conditions to filter the data (e.g., WHERE clause).

**Returns:** An array containing the retrieved data as associative arrays, or an error message string if an error occurs.

**Example:**

```php
$db = new DatabaseHandler("localhost", "username", "password", "database");

$users = $db->readData("users");
if (!is_string($users)) {
    foreach ($users as $user) {
        echo "Name: " . $user['name'] . ", Email: " . $user['email'] . "<br>";
    }
} else {
    echo "Error: " . $users;
}
```

## `updateData($table, $data, $conditions)`
Description: Updates data in the specified table in the database.

Parameters:

$table: The name of the table where the data will be updated.
$data: An associative array containing the column names and new values.
$conditions: Conditions to specify which rows to update (e.g., WHERE clause).
Returns: true if the data is successfully updated, otherwise returns an error message string.

Example:

```php
$db = new DatabaseHandler("localhost", "username", "password", "database");

$data = array(
    "name" => "Jane",
    "email" => "jane@example.com"
);

$result = $db->updateData("users", $data, "id = 1");
if ($result === true) {
    echo "Data updated successfully.";
} else {
    echo "Error: " . $result;
}
```

## `deleteData($table, $conditions)`
Description: Deletes data from the specified table in the database.

Parameters:

$table: The name of the table from which data will be deleted.
$conditions: Conditions to specify which rows to delete (e.g., WHERE clause).
Returns: true if the data is successfully deleted, otherwise returns an error message string.

Example:

```php
$db = new DatabaseHandler("localhost", "username", "password", "database");

$result = $db->deleteData("users", "id = 1");
if ($result === true) {
    echo "Data deleted successfully.";
} else {
    echo "Error: " . $result;
}
```