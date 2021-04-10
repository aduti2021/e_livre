@echo off
git add --all
git commit -m " Date (%date%-%time%)  Note : %1"
git push heroku master

