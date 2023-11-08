taskkill /IM SourceSoftwareManager.exe
cd update 
del update.zip /Q
xcopy *.* ..\ /y
del *.* /Q
cd ..
del update.zip
del update.bat