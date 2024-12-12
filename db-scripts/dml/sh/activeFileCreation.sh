user="is"
database="ProyectoIS"
inputfile="../sql/active-file-creation.sql"

mysql -u $user -p -t -D $database < $inputfile