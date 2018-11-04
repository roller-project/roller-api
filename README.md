# Roller API
api.roller.today is providing this api for public us as desired at the following url
https://api.roller.today/?wallet=0x11905bd0863ba579023f662d1935e39d0c671933

json output would be
{
"wallet":"0x11905bd0863ba579023f662d1935e39d0c671933",
"balance":"1119.8800567580"
}

just replace that wallet with your own.

feel free to add pull requests, or fork for your uwn usage

ideas this can help with for instance include
scripting daily balance reports
ok, other things :)
this would also work for nearly any ethash based coin, just change the port to the coins rpc port.

How to run this?
install php and php-curl if needed. you can then run it with command line.
if you want to have it serve up by a webserver, put the files into the web servers root directory and try the format above

you can use https://node.roller.today for the rpc address or run a pirl node locally and set it to localhost:8545 for local rpc calls


:)
