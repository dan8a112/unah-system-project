user="is"
database="ProyectoIS"
inputfile="../sql/active-enrollment.sql"

mysql -u $user -p -t -D $database < $inputfile