user="is"
database="ProyectoIS"
inputfile="../sql/active-pre-enrollment.sql"

mysql -u $user -p -t -D $database < $inputfile