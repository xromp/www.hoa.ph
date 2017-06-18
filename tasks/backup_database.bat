cd c:\xampp\mysql\bin
call mysqldump -uroot  hoa > C:\xampp\htdocs\hoa\hoa.backup\hoa_%date:~-4,4%%date:~-7,2%%date:~-10,2%.sql
echo Successfully database backup hoa_%date:~-4,4%%date:~-7,2%%date:~-10,2%
pause