user="is"
database="ProyectoIS"
inputfile="../sql/active-upload-califications.sql"

mysql -u $user -p -t -D $database < $inputfile