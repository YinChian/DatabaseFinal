@echo off

set src_dir="D:\HPC LAB\Class\Master first grade\Data Base Design\DatabaseFinal\bs-frontend-output"
set dest_dir="D:\XAMPP\htdocs\db_final"

xcopy %src_dir% %dest_dir% /E /I /Y

call export-apache.bat
