user="is"
database="ProyectoIS"
inputfile="../sql/active-revision-process.sql"

mysql -u $user -p -t -D $database < $inputfile