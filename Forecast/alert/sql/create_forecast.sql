
create database alert

use alert

CREATE TABLE IF NOT EXISTS  forecast  (
   id  int(11) NOT NULL AUTO_INCREMENT,
   forecastname  varchar(255) NOT NULL,
   functionalform  varchar(255) NOT NULL,
   points  text NOT NULL,
   description  text NOT NULL,
   createdby  int(11) NOT NULL,
   modifiedby  int(11) NOT NULL,  
   created  datetime NOT NULL,
   modified  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

INSERT INTO alert.forecast (id,forecastname,functionalform,points,description,createdby,modifiedby,created,modified) VALUES (1,'Jim FY16','2x','{[]}','asdfasdfasdfasdf',1,5, NOW(),NOW());
INSERT INTO alert.forecast (id,forecastname,functionalform,points,description,createdby,modifiedby,created,modified) VALUES (2,'Mike FY15','4x','{[]}','fewqwerwqr',2,4,NOW(),NOW());
INSERT INTO alert.forecast (id,forecastname,functionalform,points,description,createdby,modifiedby,created,modified) VALUES (3,'Suzie ','.4x','{[]}','ZcvZCvcxzvx',3,3,NOW(),NOW());
INSERT INTO alert.forecast (id,forecastname,functionalform,points,description,createdby,modifiedby,created,modified) VALUES (4,'Mary','3x-4','{[]}','btrtggfggfdgdsf',4,2,NOW(),NOW());
INSERT INTO alert.forecast (id,forecastname,functionalform,points,description,createdby,modifiedby,created,modified) VALUES (5,'Jane','.7x+2','{[]}','asfdasfewfdsfa',5,1,NOW(),NOW());

commit;

