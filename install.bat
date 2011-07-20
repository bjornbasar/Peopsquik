@echo off
md apps\views\.smarty\.compiled
md apps\views\.smarty\.cache
md log
md uploads
del apps\views\.smarty\.compiled\*
del apps\views\.smarty\.cache\*
