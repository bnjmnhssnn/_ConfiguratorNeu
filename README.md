# I Serv Configurator Plugin

Kurz & knapp alle wichtigen Funktionen

Eine Auswahloption anlegen
```yaml
-
  id: 4
  name: Server-Hardware Portal-M
  summary_name: Server-Hardware Portal-M (einmalig)
  price: 
    value: 4595
    class: 1
    info: einmalig
```
*on_switch*: Auswahloption nur anzeigen, wenn Auswahloptionen 1 oder 2 gewählt sind
```yaml
-
  id: 4
  name: Server-Hardware Portal-M
  summary_name: Server-Hardware Portal-M (einmalig)
  on_switch: 1,2
  price: 
    value: 4595
    class: 1
    info: einmalig
```
*off_switch*: Auswahloption **nicht** anzeigen, wenn Auswahloptionen 1 oder 2 gewählt sind
```yaml
-
  id: 4
  name: Server-Hardware Portal-M
  summary_name: Server-Hardware Portal-M (einmalig)
  off_switch: 1,2
  price: 
    value: 4595
    class: 1
    info: einmalig
```
Auswahloption mit komplexem Preise anlegen
```yaml
- 
  id: 12
  name: Cloud-Backup
  summary_name: Cloud-Backup (Einrichtungspauschale + jährl.)
  price: 
    -
      value: 200
      class: 1
      info: einmalige Einrichtungspauschale
      summary_name: Cloud-Backup Einrichtungspauschale (einmalig)
    -
      value: 150
      class: 2
      info: jährlich
      summary_name: Cloud-Backup Gebühr (jährl.)
      on_switch: 1,2
    -
      value: 250
      class: 2
      info: jährlich
      summary_name: Cloud-Backup Gebühr Berufsschulen (jährl.)
      on_switch: 3
```
*on_switch* und *off_switch* funktionieren auch auf Preisebene


