## What is SQL injection (SQLi)?

SQL injection (SQLi) is a web security vulnerability that allows an attacker to interfere with the queries that an application makes to its database. This can allow an attacker to view data that they are not normally able to retrieve. This might include data that belongs to other users, or any other data that the application can access. In many cases, an attacker can modify or delete this data, causing persistent changes to the application's content or behavior.

**terjemah**

Sqli adalah kerentanan pada keamanan web yang menyebabkan penyerang dapat mempengaruhi atau mengganggu query yang dibuat oleh aplikasi web. dengan serangan ini penyerang dapat melihat yang seharusnya tidak bisa dilihat atau diambil. termasuk data milik user lain, atau data lain yang dapat diakses oleh aplikasi
dalam banyak kasus penyerang dapat memodifikasi atau menghapus data, dan dapat menyebabkan perubahan pada konten dan perilaku aplikasi

---

In some situations, an attacker can escalate a SQL injection attack to compromise the underlying server or other back-end infrastructure. It can also enable them to perform denial-of-service attacks.

**terjemah**

pada situasi yang lain, penyerang dapat meningkatkan serangan SQLi
untuk menyerang server atau infrasruktur backend yang lain. dapat pula untuk melakukan serangan DDoS

---

## How to detect SQL injection vulnerabilities

You can detect SQL injection manually using a systematic set of tests against every entry point in the application. To do this, you would typically submit:

- The single quote character ' and look for errors or other anomalies.

- Some SQL-specific syntax that evaluates to the base (original) value of the entry point, and to a different value, and look for systematic differences in the application responses.

- Boolean conditions such as OR 1=1 and OR 1=2, and look for differences in the application's responses.

- Payloads designed to trigger time delays when executed within a SQL query, and look for differences in the time taken to respond.
- OAST payloads designed to trigger an out-of-band network interaction when executed within a SQL query, and monitor any resulting interactions.

---

## SQL injection in different parts of the query

Most SQL injection vulnerabilities occur within the WHERE clause of a SELECT query. Most experienced testers are familiar with this type of SQL injection.

However, SQL injection vulnerabilities can occur at any location within the query, and within different query types. Some other common locations where SQL injection arises are:

**terjemah**

kebanyakan kerentanan sqli terjadi pada klausa 'WHERE' dari Query 'SELECT'. kebanyakan tester berpengalaman mengerti jenis kerentana SQLi ini

bagaimanapun kerentanan SQLi dapat terjadi pada di queri manapun, lokasi yang sering tejadi antara lain

In UPDATE statements, within the updated values or the WHERE clause.
In UPDATE statements, within the updated values or the WHERE clause.
In INSERT statements, within the inserted values.
In SELECT statements, within the table or column name.
In SELECT statements, within the ORDER BY clause.
