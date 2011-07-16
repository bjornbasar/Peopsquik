mkdir -p application/views/.smarty/.compiled
mkdir -p application/views/.smarty/.cache
mkdir -p log
mkdir -p uploads
chmod -R 0777 application/views/.smarty/.compiled
chmod -R 0777 application/views/.smarty/.cache
chmod -R 0777 log
chmod -R 0777 uploads
rm -fr application/views/.smarty/.compiled/*
rm -fr application/views/.smarty/.cache/*
