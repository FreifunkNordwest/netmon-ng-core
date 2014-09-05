FreifunkMonitoringAPI
=====================

*freifunk node-API for the whole world ...*

Es gibt bereits Lösungen, die sich um das Monitoring von Mash-Netzwerken kümmern: ffmap-d3, libremap, openwikimap und netmon um nur einige zu nennen.
Bei Gesprächen mit anderen Freifunkern beim WirelessCommunityWeekend 2014 in Berlin kam der Wunsch nach mehr zusammenarbeit auf. Da für Oldenburg und Franken eine neue Monitoring-Lösung erstellt werden soll haben wir beschlossen die bestehenden Systeme anzuschauen und eine erste gemeinsame Schnittstelle zu schaffen auf der idealer Weise später mehrere Communities verschiedene technische Lösungen aufsetzen können.

**Bestehende Freifunk-APIs**
* [Netmon API](https://wiki.freifunk-ol.de/w/Netmon/API)
* [Libremap API](https://github.com/libremap/libremap-api/blob/master/doc-api.md)
* [OpenWifiMap API](https://github.com/freifunk/openwifimap-api)
* [ffmap-d3](http://freifunk.in-kiel.de/ffmap/nodes.json) verwendet [GeoJSON](http://geojson.org/geojson-spec.html)

**Nützliche Links:**
* [Best Practices for Designing a Pragmatic RESTful API](http://www.vinaysahni.com/best-practices-for-a-pragmatic-restful-api)
* [Freifunk Community-API Specs]( https://github.com/freifunk/api.freifunk.net/tree/master/specs )

Spezifikation
-------------

Die eigentliche Spezifikation erfolgt als [JSON-Schema](http://json-schema.org/) um bestehende Tools zur [Validierung](https://github.com/justinrainbow/json-schema) und [Generierung](http://www.alpacajs.org/) nutzen zu können. Schemata sind in der Form VERSION.spec.json gehalten.

Die Versionierung
-----------------

Grundlage, um eine einheitliche und stabiele Schnittstelle bereitstellen zu können ist eine strikte Versionierung.
Wir haben daher beschlossen auf [semantische Versionierung](http://semver.org/) zu setzen.

Jeder Versionsnummer setzt sich aus drei Feldern zusammen (z.B. v1.0.0):

	MAJOR.MINOR.PATCH
	
 * **MAJOR** werden nur bei Änderungen hochgezählt die inkompatiebel mit der vorherigen Version sind.
 * **MINOR** werden hochgezählt, wenn eine Abwärts-Kompatieble Änderung erfolgt.
 * **PATCH** werden bei jeder Rückwärt-kompatieblen Fehlerbehebungen und kleinenen Ergänzung hochgezählt.
 
Aktuelle Änderungen erfolgen in der **CURRENT** Version (z.B. current.json). Enthält die CURRENT-Version Änderungen, die vom Entwicklungsteam mitgetragen werden wird eine neue feste Versionsnummer (z.B. 1.0.1) erstellt.

Bestehende Versionen werden nicht mehr geändert.

API
===

API-Key
--------
Der API-Key besteht aus einer beliebigen eindeutigen Zeichenfolge und dient als Nachweis der Berechtigung eines Geräts oder einer Person eine bestimmte Aktion an der API durchführen zu dürfen.
Der API-Key bildet daher das zentrale Element der Applikation mit dem alle Objekte direkt oder indirekt verknüpft sein müssen und dessen Berechtigung mit jeder Interaktion geprüft werden muss.

Siehe auch: [Wikipedia](https://en.wikipedia.org/wiki/Application_programming_interface_key)

Anlegen eines neuen API-Keys
---------
Grundsätzlich kann an der API immer ein neuer API-Key mit einem Standardberechtigungslevel angefordert werden das die Erledigung von Grundaufgaben ermöglicht. Gehen wir davon aus, dass mehrere Berechtigungslevel existieren (z.B. Administrator und Benutzer) so sollte das Standardberechtigungslevel "Benutzer" sein. Dieses Berechtigungslevel sollte alle Aktionen erlauben von denen nur die Objekte des eigenen API-Keys und nicht die Objekte anderer API-Keys betroffen sind (ein API-Key mit Benutzerlevel darf keine Objekte anderer API-Keys löschen. Ein API-Key mit Administratorlevel dürfte dies hingegen).

Grundsätzlich kann man das Anlegen eines neuen API-Keys mit einem Identifikationsprozess verbinden (z.B. Emailverifikation). Wir gehen jedoch davon aus, dass die API überwiegen von vollautomatisierten Prozessen genutzt werden wird weshalb wir darauf verzichten.

| URL                  | HTTP method | Description  | 
| -------------------- |:-----------:| ------------ |
| /api/apikey/      | GET         | Create new API-Key with Key :key |


Bei Anforderung eines neuen API-Keys wird in der Datenbank ein neuer API-Key angelegt und dieser von der API zurückgeliefert. Die anfragende Applikation sollte diesen API-Key nun speichern und ihn bei allen nachfolgenden Interaktionen mit der API nutzen.

Übermittlung des API-Keys an die API
--------
Es gibt verschiedene Methoden bei einem Request an die API den API-Key mitzuliefern:
* Nutzung einer Benutzer-ID in Verbindung mit der Signierung des Requests mittels API Key (Amazon Cloud)
* Oauth etc.
* Übergabe per GET
* Übergabe per POST
* Übergabe per Authorization header (http://tools.ietf.org/html/draft-ietf-httpbis-p7-auth-13#page-8)

Entwickelt werden soll eine Anwendung, die zwar gegen gängige Angriffe sicher ist, aber nicht höchsten Sicherheitsansprüchen genügen muss. Wir benötigen eine Methode die einfach und nach Möglichkeit ohne spezielle Bibliotheken auch auf den Routern selbst zu implementieren ist.

Die Methoden mittels Signierung und Oauth etc. fallen daher raus. Sie sind vergleichsweise aufwendig zu implementieren und benötigen weitere Bibliotheken bei denen wir nicht davon ausgehen können, dass sie auf allen Systemen verfügbar sind. Die übergabe des API-Keys mittels GET in der URL wäre sehr einfach machbar, jedoch läuft diese Methode dem URL-Design einer REST-API zuwider. Außerdem sollte eine Web-API grundsätzlich auch per HTTPS abrufbar sein und in diesem Fall würde der API-Key als schützenswerter Parameter unverschlüsselt übertragen. Die übergabe per POST wäre zwar verschlüsselt, jedoch zerstören wir uns damit die klare unterscheidung zwischen GET, POST, PUT und DELETE Requests. Die Übergabe per http authorisation header erfolgt bei ssl verschlüsselt, stört keine REST-API Prinzipien, wird von allen gängigen Programmen unterstützt (unter anderem auch von dem in Gluon verwendeten Busybox Wget mittels --header option) und ist extra für diesen Zweck vorgesehen.

Beispiel mit Cur:
curl -H "Authorization: apikey your_api_key_here" http://www.example.com

Knoten
------

| URL                  | HTTP method | Description  | 
| -------------------- |:-----------:| ------------ |
| /api/router/:id      | GET         | Get router doc with ID :id |
| /api/router/         | POST        | Create new router doc with autogenerated ID |
| /api/router/:id      | PUT         | Update router doc with ID :id |
| /api/router/:id      | DELETE      | Delete router doc with ID :id |
| /api/routers_by_location/:bbox | GET | Get routers by geolocation bounding box :bbox |
| /api/routers_by_alias | GET, POST | Get routers by alias |
