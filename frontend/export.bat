@echo off

@REM cd %1

setlocal EnableDelayedExpansion

REM 定義來源和目的地資料夾
set src_dir="I:\Class\Database\DatabaseFinal\bs-frontend-output"
set dest_dir="I:\Class\Database\DatabaseFinal\resources"

REM 指定原副檔名和新副檔名
set "old_ext=html"
set "new_ext=blade.php"

REM 定義要轉換的頁面資料夾
set pages=( "customer profile" "feedback pages" "login pages" "shipping pages" "shopping pages" "static pages" "stock management" )



REM 創建目的地資料夾結構
xcopy "%src_dir%\assets\bootstrap\css" "%dest_dir%\css" /E /I /Y
xcopy "%src_dir%\assets\bootstrap\js" "%dest_dir%\js" /E /I /Y
xcopy "%src_dir%\assets\css" "%dest_dir%\css" /E /I /Y
xcopy "%src_dir%\assets\img" "%dest_dir%\img" /E /I /Y
xcopy "%src_dir%\assets\js" "%dest_dir%\js" /E /I /Y

@REM REM 迴圈處理每個頁面資料夾
@REM for %%p in %pages% do (
@REM     xcopy "%src_dir%\%%~p" "%dest_dir%\views\%%~p" /E /I /Y
@REM     echo "%%p"
@REM     cd /d "%dest_dir%\views\%%p"
@REM     for %%f in (*.%old_ext%) do (
@REM         set "full_path=%%f"
@REM         set "file_name=%%~nf"
@REM         ren "!full_path!" "!file_name!.%new_ext%"
@REM     )
@REM )

for %%p in %pages% do (
    xcopy "%src_dir%\%%~p" "%dest_dir%\views\%%~p" /E /I /Y
    echo "Processing %%p"
    cd /d "%dest_dir%\views\%%p"
    for %%f in (*.%old_ext%) do (
        set "full_path=%%f"
        set "file_name=%%~nf"
        if exist "!file_name!.%new_ext%" (
            echo "!file_name!.%new_ext%" already exists. Skipping.
        ) else (
            ren "!full_path!" "!file_name!.%new_ext%"
        )
    )
)