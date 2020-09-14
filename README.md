# orderus

This is little project for eMAG.
Some informations:

1) There is false database in "database.php" file. Every special skill has its slug, name and moment when is used. Every player can use some special skills with defined percent of chance.
2) The "View" part of project is poor orphant, so please don't look at this ;)
3) All Skills are managed in Skills class (surprised?). You can add more skills by adding this to "database" and creating new methods using its slug. I created methods for special skills which are used in project and also some util methods. In the future it will be good to add new skills by extending this class.
4) In Player class there is nothing very interesting now. It create object Player by player name, because of false database. Normally it shoud be player ID recupered from database.
5) Battle class has methods for battle. Method "turn" is not full turn, but only one part of games' turn - only one player attacks. So game turn is in fact two turns with swap players between them.
6) Project engine is in Boostrap class.

There are some empty methods and useless (for the moment) elements. They can be used in the future, so I left them for the future generation...

Enjoy
