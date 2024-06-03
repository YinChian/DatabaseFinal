@echo off

REM 定義來源和目的地資料夾
set src_dir="I:\Class\Database\DatabaseFinal\bs-frontend-output"
set dest_dir="C:\xampp\htdocs\db_final"

xcopy "%src_dir%" "%dest_dir%" /E /I /Y