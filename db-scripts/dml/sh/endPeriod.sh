user="is"
database="ProyectoIS"
inputfile="../sql/end-period.sql"

mysql -u $user -p -t -D $database < $inputfile