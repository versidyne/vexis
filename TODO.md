Vexis - To Do List
=====

#####Protocols
Universal Routing Protocol
* Syntax: JSON
* Usage: Messaging, Notifications, Misc Data
* Applications: Universal
* Gateway: API

```js
{
    "version": 2.0,
	"routing": "username, ip, group, or channel",
    "to": "recipient",
    "from": "sender",
    "payload": {
        "type": "message",
		"format": "text",
        "data": "Hello World!"
    },
    "payloads": [
        {
            "type": "contact",
			"format": "vcard",
            "data": "Alex"
        },
        {
            "type": "contact",
			"format": "vcard",
            "data": "Hilary"
        }
    ]
}
```

XML
* ATOM
* RSS

#####Admin Bar
This will need a setting to enable and disable it, possibly also customize it in the same variable.  Empty variable can disable.

#####Widgets
These will connect through plugins, added into the widget cloud.  Each widget will have its set of functionality, through a class structure, run by the plugin.  This is essentially the "display" portion of the plugin's output.  It can be anchored to various spots in the system (i.e. post bottom, header, toolbar, etc).

#####Remote Nodes
The core needs to be able to synchronize changes to itself and push them to the main server.  If each website can have unlimited subordinates and one upload, then the network can create a hierarchy tree to disseminate, synchronize, and update codes efficiently.  This can also be utilized to create a network tree that is based on regions.
* I can also use a plugin system to allow a server application to switch between protocols or features
* Server applications should also be able to be controlled through the website using a console or something of the sort

#####Marketplace
Plugins
* This will allow a plugin to be downloaded and installed into the system easily, without the usage of ftp or anything of the sort.

Templates
* This will allow a template to be downloaded and installed into the system easily, without the usage of ftp or anything of the sort.

Stores
* This will allow for a company / freelancer to have a store that holds all their work and prices, which can easily be billed through paypal, google checkout, or whatever else have you.

Freelancers
* This will work in such a way as to allow bidding from freelancers on a particular project that has been requested.  This will allow commerce to take place, easily, for small businesses.
* This will allow a person to also get paid through the marketplace.
* This will only pay out once the employer has been satisfied.

#####Updater
* Utilize MD5 Hashes to gather file changes and possibly diff files to detect additions.
* Possibly utilize an algorithm to sort out similarities in the files, only leaving the differences.
