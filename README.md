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

pad id numbers to specified length [`-p` or `--pad-to-length`]:

```bash
./csv2dml.phar convert students.csv output.dml -p 7
# turns 999999 to 0999999 in output DML
```

exclude users from dml file [`-e` or `--excluded-identifiers`]:

```bash
./csv2dml.phar convert students.csv output.dml -p 7 -e excluded.csv
```

## Format

Users CSV Input:

```csv
first_name,last_name,identifier,email,company
Luke,Skywalker,9999999,skywal@gmailcom,JediAcademy
```

Excluded Identifiers CSV:

```csv
identifier
9999998
9999997
9999996
9999995
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