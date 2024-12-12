user="is"
database="ProyectoIS"
inputfile="../sql/active-upload-results.sql"

mysql -u $user -p -t -D $database < $inputfile