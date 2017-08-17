# CSV 2 DML

## Setup

* Install PHP on your system.
* Download the binary(csv2dml.phar) from the [releases page](https://github.com/TheSageColleges/csv2dml/releases).

## Usage:

convert `students.csv` to `students.csv.dml`:

```bash
./csv2dml.phar convert students.csv
```

output to a specific filename:

```bash
./csv2dml.phar convert students.csv output.dml
```

pad id numbers to specified length:

```bash
./csv2dml.phar convert students.csv -p 7
# turns 999999 to 0999999 in output DML
```

## Format

CSV Input:

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