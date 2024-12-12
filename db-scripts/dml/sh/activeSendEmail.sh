user="is"
database="ProyectoIS"
inputfile="../sql/active-send-email.sql"

mysql -u $user -p -t -D $database < $inputfile