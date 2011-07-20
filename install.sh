mkdir -p apps/views/.smarty/.compiled
mkdir -p apps/views/.smarty/.cache
mkdir -p log
mkdir -p uploads
chmod -R 0777 apps/views/.smarty/.compiled
chmod -R 0777 apps/views/.smarty/.cache
chmod -R 0777 log
chmod -R 0777 uploads
rm -fr apps/views/.smarty/.compiled/*
rm -fr apps/views/.smarty/.cache/*
