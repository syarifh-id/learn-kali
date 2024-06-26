## Union attack

When an application is vulnerable to SQL injection, and the results of the query are returned within the application's responses, you can use the UNION keyword to retrieve data from other tables within the database. This is commonly known as a SQL injection UNION attack.

**Terjemahan**

ketika sebuah aplikasi rentan terhadap serangan sql injection dan hasil dari query dikembalikan melalui respon dari aplikasi, maka kita dapat menggunakan keyword UNION untuk mengambil data dari tabel lain dalam database. serangan ini dikenal dengan SQli Union attack

The UNION keyword enables you to execute one or more additional SELECT queries and append the results to the original query. For example:

SELECT a, b FROM table1 UNION SELECT c, d FROM table2

This SQL query returns a single result set with two columns, containing values from columns a and b in table1 and columns c and d in table2.

**terjemahan**

Keyword UNION memungkinkan kita untuk mengeksekusi satu atau lebih queri SELECT tambahan dan menambahkan hasilnya ke hasil dari queri awal

SELECT a, b FROM table1 UNION SELECT c, d FROM table2

queri sql ini akan mengembalikan satu hasil dengan 2 kolom, yang berisi value dari colom a dan b dari tabel1 dan colom c dan d dari tabel2

For a UNION query to work, two key requirements must be met:

- The individual queries must return the same number of columns.
- The data types in each column must be compatible between the individual queries.

To carry out a SQL injection UNION attack, make sure that your attack meets these two requirements. This normally involves finding out:

- How many columns are being returned from the original query.
- Which columns returned from the original query are of a suitable data type to hold the results from the injected query.

**terjemah**
agar queri Union dapat dilakukan, ada 2 persyaratan yang harus dipenuhi

- queri harus mengembalikan jumlah kolom yang sama
- type data pada setiap kolom harus kompatibel antara queri

untuk menjalankan serangan sql injection, pastikan memenuhi 2 persyaratan tadi. biasanya dengan pertanyaan:

- berapa kolom yang dikembalikan oleh queri yang asli
- kolom mana yang dikembalikan dari wueri asli yang sesuai dengan queri yang akan menampung hasil dari injeksi queri

---

## Determining the number of columns required

When you perform a SQL injection UNION attack, there are two effective methods to determine how many columns are being returned from the original query.

One method involves injecting a series of ORDER BY clauses and incrementing the specified column index until an error occurs. For example, if the injection point is a quoted string within the WHERE clause of the original query, you would submit:

' ORDER BY 1--
' ORDER BY 2--
' ORDER BY 3--
etc.

This series of payloads modifies the original query to order the results by different columns in the result set. The column in an ORDER BY clause can be specified by its index, so you don't need to know the names of any columns. When the specified column index exceeds the number of actual columns in the result set, the database returns an error, such as:
The ORDER BY position number 3 is out of range of the number of items in the select list.

**Terjemah**

ketika kita melakukan serangan SQli UNION ada dua cara yang efektif untuk menetukan jumlah kolom yang dikembalikan oleh queri yang asli.

salah satu metode untuk yang digunakan adalah menggunakan klausa ORDER BY dengan memasukkan satu persatu index kolom sampai muncul pesan error. jika titik injeksi adalah string dalam tanda petik di dalam klausa WHERE pada query asli kita bisa menggunakan :
' ORDER BY 1--
' ORDER BY 2--
' ORDER BY 3--
etc.

kumpulan payload ini menyebabkan queri asli untuk mengurutkan berdasarkan kolom yang bebeda di set hasil.
kolom pada kalusa ORDER BY dapat ditentukan dengan index dari kolom tersebut. jadi kita tidak perlu tahu nama kolom.
ketika indek yang dimasukkan melebihi jumlah kolom yang asli pada set hasil, maka database mengembalikan pesan error. :

---

The application might actually return the database error in its HTTP response, but it may also issue a generic error response. In other cases, it may simply return no results at all. Either way, as long as you can detect some difference in the response, you can infer how many columns are being returned from the query.

The second method involves submitting a series of UNION SELECT payloads specifying a different number of null values:

' UNION SELECT NULL--
' UNION SELECT NULL,NULL--
' UNION SELECT NULL,NULL,NULL--
etc.
If the number of nulls does not match the number of columns, the database returns an error, such as:

"All queries combined using a UNION, INTERSECT or EXCEPT operator must have an equal number of expressions in their target lists."

We use NULL as the values returned from the injected SELECT query because the data types in each column must be compatible between the original and the injected queries. NULL is convertible to every common data type, so it maximizes the chance that the payload will succeed when the column count is correct.

**terjemah**

Apliksi sebenarnya mengembalikan pesan database error pada http responnya, tetapi http respon tersebut juga mengembalikan pesan error yang umum. pada kasus lain tidak mengembalikan hasil sama sekali.cara lain selama kita mendeteksi adanya perbedaan pada repons kita dapat menebak berapa jumlah kolom yang dikembalikan dari query asli.
cara yang kedua adalah menggunkan UNION ATTACK dan null value dalam jumlah tertentu

' UNION SELECT NULL--
' UNION SELECT NULL,NULL--
' UNION SELECT NULL,NULL,NULL--
etc.
jika jumlah null tidak sama dengan jumlah kolom maka data base akan megembalikan error seperti :
"All queries combined using a UNION, INTERSECT or EXCEPT operator must have an equal number of expressions in their target lists."

kita menggunakan value null sebagai value yang dikembalikan dari queri select yang diinject, karena type data pada setiap kolom yang asli dan yang diinject harus kompatibel.NULL adalah value yang kompetible dengan kebanyakan type data.

---

As with the ORDER BY technique, the application might actually return the database error in its HTTP response, but may return a generic error or simply return no results. When the number of nulls matches the number of columns, the database returns an additional row in the result set, containing null values in each column. The effect on the HTTP response depends on the application's code. If you are lucky, you will see some additional content within the response, such as an extra row on an HTML table. Otherwise, the null values might trigger a different error, such as a NullPointerException. In the worst case, the response might look the same as a response caused by an incorrect number of nulls. This would make this method ineffective.

Using a SQL injection UNION attack to retrieve interesting data
When you have determined the number of columns returned by the original query and found which columns can hold string data, you are in a position to retrieve interesting data.

Suppose that:

The original query returns two columns, both of which can hold string data.
The injection point is a quoted string within the WHERE clause.
The database contains a table called users with the columns username and password.
In this example, you can retrieve the contents of the users table by submitting the input:

' UNION SELECT username, password FROM users--
In order to perform this attack, you need to know that there is a table called users with two columns called username and password. Without this information, you would have to guess the names of the tables and columns. All modern databases provide ways to examine the database structure, and determine what tables and columns they contain.

Retrieving multiple values within a single column
In some cases the query in the previous example may only return a single column.

You can retrieve multiple values together within this single column by concatenating the values together. You can include a separator to let you distinguish the combined values. For example, on Oracle you could submit the input:

' UNION SELECT username || '~' || password FROM users--
This uses the double-pipe sequence || which is a string concatenation operator on Oracle. The injected query concatenates together the values of the username and password fields, separated by the ~ character.

The results from the query contain all the usernames and passwords, for example:

...
administrator~s3cure
wiener~peter
carlos~montoya
...
Different databases use different syntax to perform string concatenation. For more details, see the SQL injection cheat sheet.
