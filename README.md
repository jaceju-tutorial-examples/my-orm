# MyORM

## 外部操作
$user = User::find(1);
$articles = $user->findArticles();

## 內部實作分類

### Table Gateway

把邏輯操作與 Table 物件分離

### Active Record

直接在 Row (Record) 上面加入邏輯操作

## 需要的類別

* Db ：包裝 PDO
* Db\Table ：包裝 Table
* Db\Row ： Active Record

## 實作目標

### Db

* 包裝把 PDO 相關方法
* 提供 factory 方法
* 延遲連接