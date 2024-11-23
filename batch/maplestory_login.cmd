@echo off&setlocal enabledelayedexpansion

ping -n 1 tw.login.maplestory.gamania.com > nul
if errorlevel 1 (
  echo. >> "C:\Windows\System32\drivers\etc\hosts"
  echo 127.0.0.1 tw.login.maplestory.gamania.com>> "C:\Windows\System32\drivers\etc\hosts"
)

set /p a=Please input your account:
echo Don't close this command.Authenticate the file integrity...
start Maplestory.exe 3.37.247.141 8484
:floop
break > log.txt
FORFILES /M "*.wz" /S /C "cmd /c echo @fdate" >> log.txt
set /a fcount=0
set /a value=0

For /F %%n in (log.txt) do (
set /a fcount+=1

if !fcount! == 1 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 2 (
  if not %%n == 2022/9/8 set /a value = 0
  if %%n == 2022/9/8 set /a value+=1
)

if !fcount! == 3 (
  if not %%n == 2022/9/15 set /a value = 0
  if %%n == 2022/9/15 set /a value+=1
)

if !fcount! == 4 (
  if not %%n == 2016/1/25 set /a value = 0
  if %%n == 2016/1/25 set /a value+=1
)

if !fcount! == 5 (
  if not %%n == 2010/4/6 set /a value = 0
  if %%n == 2010/4/6 set /a value+=1
)

if !fcount! == 6 (
  if not %%n == 2023/1/18 set /a value = 0
  if %%n == 2023/1/18 set /a value+=1
)

if !fcount! == 7 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 8 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 9 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 10 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 11 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 12 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 13 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 14 (
  if not %%n == 2023/1/9 set /a value = 0
  if %%n == 2023/1/9 set /a value+=1
)

if !fcount! == 15 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 16 (
  if not %%n == 2023/1/18 set /a value = 0
  if %%n == 2023/1/18 set /a value+=1
)

if !fcount! == 17 (
  if not %%n == 2010/4/3 set /a value = 0
  if %%n == 2010/4/3 set /a value+=1
)

if !fcount! == 18 (
  if not %%n == 2016/1/25 set /a value = 0
  if %%n == 2016/1/25 set /a value+=1
)

set f!fcount!=%%n
)

if !value! == 18 (	
    "curl/bin/curl.exe" -X POST -H "Content-Type: application/json" -d '{"name":"%a%"}' -H "Authorization: Bearer kidomapleqwrwqrrqwQAZ4rfv" https://3.37.247.141/auth/api/ --insecure 
)

@ping 127.0.0.1 -n 5 -w 1000 > nul
goto floop