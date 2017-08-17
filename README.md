# CSV 2 DML

Usage:

Convert `students.csv` to `students.csv.dml`

```bash
./csv2dml.phar convert students.csv
```

output to a filename

```bash
./csv2dml.phar convert students.csv output.dml
```

CSV Example:

```csv
first_name,last_name,identifier,email,action,company
Luke,Skywalker,9999999,skywal@gmailcom,update,JediAcademy
```

DML Output:

```text
I L1 U1 ^9999999^^^
T Names
F FName ^Luke^^^
F LName ^Skywalker^^^
F Company  ^JediAcademy^^^
W
T UDF
F UdfNum  ^1^^^
F UdfText ^9999999^^^
W
T UDF
F UdfNum  ^2^^^
F UdfText ^skywal@gmailcom^^^
W
```
