DROP TABLE IF EXISTS ci_sessions;
CREATE TABLE ci_sessions (
  id varchar(40) NOT NULL,
  ip_address varchar(45) NOT NULL,
  timestamp int(10) unsigned NOT NULL DEFAULT '0',
  data blob NOT NULL,
  PRIMARY KEY (id),
  KEY timestamp (timestamp)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS login_attempts;
CREATE TABLE login_attempts (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  ip_address varchar(16) NOT NULL,
  login varchar(100) DEFAULT NULL,
  time int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS migrations;
CREATE TABLE migrations (
  version bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS settings;
CREATE TABLE settings (
  id tinyint(1) NOT NULL,
  site_logo varchar(220) NOT NULL DEFAULT 'static/images/logo.png',
  site_name varchar(100) NOT NULL DEFAULT 'MEDDS',
  site_description varchar(100) DEFAULT 'Online Medical Directory and Services',
  site_language varchar(40) NOT NULL DEFAULT 'english',
  pagination_limit mediumint(8) DEFAULT NULL,
  upload_limit tinyint(4) NOT NULL DEFAULT '5',
  no_reply varchar(100) DEFAULT NULL,
  privacy_policy text,
  terms_of_service text,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO settings (id, site_logo, site_name, site_description, site_language, pagination_limit, upload_limit, no_reply, privacy_policy, terms_of_service) VALUES (1, 'assets/images/logo.png', 'MEDDS', 'Online Medical Directory and Services', 'english', 24, 5, '', '', '');

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  ip_address varchar(16) NOT NULL,
  username varchar(100) NOT NULL,
  password varchar(80) NOT NULL,
  salt varchar(40) NOT NULL,
  email varchar(100) NOT NULL,
  activation_code varchar(40) DEFAULT NULL,
  forgotten_password_code varchar(40) DEFAULT NULL,
  forgotten_password_time int(11) unsigned DEFAULT NULL,
  remember_code varchar(40) DEFAULT NULL,
  created_on int(11) unsigned NOT NULL,
  last_login int(11) unsigned DEFAULT NULL,
  active tinyint(1) unsigned NOT NULL,
  avatar varchar(220) DEFAULT NULL,
  thumbnail varchar(220) DEFAULT NULL,
  first_name varchar(20) NOT NULL,
  last_name varchar(20) NOT NULL,
  address varchar(220) DEFAULT NULL,
  phone varchar(100) DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;
INSERT INTO users (id, ip_address, username, password, salt, email, activation_code, forgotten_password_code, forgotten_password_time, remember_code, created_on, last_login, active, avatar, thumbnail, first_name, last_name, address, phone) VALUES (1, '127.0.0.1', 'admin', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1558716593, 1, 'https://fakeimg.pl/300/', 'https://fakeimg.pl/150/', '', '', NULL, NULL);

DROP TABLE IF EXISTS groups;
CREATE TABLE groups (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(20) NOT NULL,
  description varchar(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY id (id)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
INSERT INTO groups (id, name, description) VALUES (1, 'admin', 'Administrator');
INSERT INTO groups (id, name, description) VALUES (2, 'doctors', 'Medical Practitioner');
INSERT INTO groups (id, name, description) VALUES (3, 'manager', 'Hospital Administrator');
INSERT INTO groups (id, name, description) VALUES (4, 'users', 'General User');

DROP TABLE IF EXISTS users_groups;
CREATE TABLE users_groups (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  user_id mediumint(8) unsigned NOT NULL,
  group_id mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY group_id (group_id),
  CONSTRAINT users_groups_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT users_groups_ibfk_2 FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
INSERT INTO users_groups (id, user_id, group_id) VALUES (1, 1, 1);

DROP TABLE IF EXISTS companies;
CREATE TABLE companies (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  location_id smallint(5) unsigned DEFAULT NULL,
  name varchar(100) NOT NULL,
  slug varchar(100) NOT NULL,
  logo varchar(220) DEFAULT NULL,
  preview varchar(220) DEFAULT NULL,
  slogan varchar(100) DEFAULT NULL,
  description text,
  phone varchar(100) DEFAULT NULL,
  email varchar(100) DEFAULT NULL,
  address varchar(220) DEFAULT NULL,
  latitude varchar(20) DEFAULT NULL,
  longitude varchar(20) DEFAULT NULL,
  open_hrs varchar(100) DEFAULT NULL,
  active tinyint(1) NOT NULL DEFAULT '1',
  created_on int(11) unsigned NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=9527 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS companies_files;
CREATE TABLE companies_files (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  company_id mediumint(8) unsigned DEFAULT NULL,
  url varchar(220) NOT NULL,
  type varchar(10) NOT NULL,
  caption varchar(220) NOT NULL,
  PRIMARY KEY (id),
  KEY company_id (company_id),
  CONSTRAINT companies_files_ibfk_1 FOREIGN KEY (company_id) REFERENCES companies (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19053 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS company_types;
CREATE TABLE company_types (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  parent_id smallint(5) unsigned DEFAULT NULL,
  name varchar(50) NOT NULL,
  code varchar(50) NOT NULL,
  description varchar(220) DEFAULT NULL,
  created_on int(11) unsigned NOT NULL,
  PRIMARY KEY (id),
  KEY parent_id (parent_id),
  CONSTRAINT company_types_ibfk_1 FOREIGN KEY (parent_id) REFERENCES company_types (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
INSERT INTO company_types (id, parent_id, name, code, description, created_on) VALUES (1, NULL, 'General Hospital', 'GHSP', 'A non-specialized hospital, treating patients suffering from all types of medical condition', 1558631554);
INSERT INTO company_types (id, parent_id, name, code, description, created_on) VALUES (2, NULL, 'Specialty Hospital', 'SHSP', 'A hospital that is primarily or exclusively engaged in the care and treatment of patients with a cardiac condition, orthopedic condition, a condition requiring a surgical procedure and “any other specialized category of ', 1558631554);
INSERT INTO company_types (id, parent_id, name, code, description, created_on) VALUES (3, NULL, 'College/ University Hospital', 'CHSP', 'A university hospital is an institution which combines the services of a hospital with the education of medical students and with medical research', 1558631554);
INSERT INTO company_types (id, parent_id, name, code, description, created_on) VALUES (4, NULL, 'Government Hospital', 'CHSP', 'A public hospital or government hospital is a hospital which is owned by a government and receives government funding', 1558631554);

DROP TABLE IF EXISTS companies_types;
CREATE TABLE companies_types (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  company_id mediumint(8) unsigned DEFAULT NULL,
  company_type_id smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (id),
  KEY company_id (company_id),
  KEY company_type_id (company_type_id),
  CONSTRAINT companies_types_ibfk_1 FOREIGN KEY (company_id) REFERENCES companies (id) ON DELETE CASCADE,
  CONSTRAINT companies_types_ibfk_2 FOREIGN KEY (company_type_id) REFERENCES company_types (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9527 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS companies_users;
CREATE TABLE companies_users (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  user_id mediumint(8) unsigned NOT NULL,
  company_id mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY company_id (company_id),
  CONSTRAINT companies_users_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT companies_users_ibfk_2 FOREIGN KEY (company_id) REFERENCES companies (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47631 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS company_facilities;
CREATE TABLE company_facilities (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  code varchar(50) NOT NULL,
  description varchar(220) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
INSERT INTO company_facilities (id, name, code, description) VALUES (1, 'Dental facility', 'DNTL', 'An experienced Dental surgeon provides procedures like Dental Extractions, RCT, Scaling /Cleaning, Fillings, Local curettage.');
INSERT INTO company_facilities (id, name, code, description) VALUES (2, 'Ambulance Services', 'AMBL', 'Hospital has a patient transport vehicle available');
INSERT INTO company_facilities (id, name, code, description) VALUES (3, 'Pharmacy', 'PHM', 'Quality medicines are available to patients on doctor prescription');
INSERT INTO company_facilities (id, name, code, description) VALUES (4, 'Laboratory services', 'LAB', 'Trained laboratory staff are available for carrying out specialised tests');
INSERT INTO company_facilities (id, name, code, description) VALUES (5, 'Radiology/X-ray facility', 'XRAY', 'Facility for diagnosing and treating injuries and diseases using medical imaging (radiology) procedures');

DROP TABLE IF EXISTS companies_facilities;
CREATE TABLE companies_facilities (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  company_id mediumint(8) unsigned DEFAULT NULL,
  company_facility_id smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (id),
  KEY company_id (company_id),
  KEY company_facility_id (company_facility_id),
  CONSTRAINT companies_facilities_ibfk_1 FOREIGN KEY (company_id) REFERENCES companies (id) ON DELETE CASCADE,
  CONSTRAINT companies_facilities_ibfk_2 FOREIGN KEY (company_facility_id) REFERENCES company_facilities (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23952 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS doctor_specialities;
CREATE TABLE doctor_specialities (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(50) NOT NULL,
  code varchar(20) NOT NULL,
  description varchar(220) DEFAULT NULL,
  created_on int(11) unsigned NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
INSERT INTO doctor_specialities (id, name, code, description, created_on) VALUES (1, 'Dermatologist', 'DMT', 'Dermatologists are physicians who treat adult and pediatric patients with disorders of the skin, hair, nails, and adjacent mucous membranes.', 1558631554);
INSERT INTO doctor_specialities (id, name, code, description, created_on) VALUES (2, 'Optician', 'OPT', 'Physicians specializing in ophthalmology develop comprehensive medical and surgical care of the eyes', 1558631554);
INSERT INTO doctor_specialities (id, name, code, description, created_on) VALUES (3, 'Pediatrician', 'PDT', 'Physicians specializing in pediatrics work to diagnose and treat patients from infancy through adolescence', 1558631554);
INSERT INTO doctor_specialities (id, name, code, description, created_on) VALUES (4, 'Psychiatrist', 'PSYC', 'Physicians specializing in psychiatry devote their careers to mental health and its associated mental and physical ramifications.', 1558631554);
INSERT INTO doctor_specialities (id, name, code, description, created_on) VALUES (5, 'Dentist', 'DST', 'Physicians specializing in treatment of diseases affecting the teeth, mouth and gums.', 1558631554);

DROP TABLE IF EXISTS location_types;
CREATE TABLE location_types (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  parent_id smallint(5) unsigned DEFAULT NULL,
  name varchar(50) NOT NULL,
  code varchar(50) NOT NULL,
  created_on int(11) unsigned NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY parent_id (parent_id),
  CONSTRAINT location_types_ibfk_1 FOREIGN KEY (parent_id) REFERENCES location_types (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
INSERT INTO location_types (id, parent_id, name, code, created_on) VALUES (1, NULL, 'Country', 'CNT', 1558631553);
INSERT INTO location_types (id, parent_id, name, code, created_on) VALUES (2, 1, 'State', 'STT', 1558631553);
INSERT INTO location_types (id, parent_id, name, code, created_on) VALUES (3, 2, 'City', 'CTY', 1558631553);

DROP TABLE IF EXISTS locations;
CREATE TABLE locations (
  id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  parent_id smallint(5) unsigned DEFAULT NULL,
  location_type_id smallint(5) unsigned NOT NULL,
  name varchar(50) NOT NULL,
  code varchar(50) NOT NULL,
  created_on int(11) unsigned NOT NULL,
  PRIMARY KEY (id),
  KEY parent_id (parent_id),
  KEY location_type_id (location_type_id),
  CONSTRAINT locations_ibfk_1 FOREIGN KEY (parent_id) REFERENCES locations (id) ON DELETE CASCADE,
  CONSTRAINT locations_ibfk_2 FOREIGN KEY (location_type_id) REFERENCES location_types (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
INSERT INTO locations (id, parent_id, location_type_id, name, code, created_on) VALUES (1, NULL, 1, 'United States', 'US', 1558631553);
INSERT INTO locations (id, parent_id, location_type_id, name, code, created_on) VALUES (2, 1, 2, 'California', 'CLF', 1558631553);
INSERT INTO locations (id, parent_id, location_type_id, name, code, created_on) VALUES (3, 1, 2, 'Florida', 'FLD', 1558631553);
INSERT INTO locations (id, parent_id, location_type_id, name, code, created_on) VALUES (4, 1, 2, 'New York', 'NY', 1558631553);
INSERT INTO locations (id, parent_id, location_type_id, name, code, created_on) VALUES (5, 2, 3, 'Los Angeles', 'LA', 1558631553);
INSERT INTO locations (id, parent_id, location_type_id, name, code, created_on) VALUES (6, 2, 3, 'San Francisco', 'SA', 1558631553);
INSERT INTO locations (id, parent_id, location_type_id, name, code, created_on) VALUES (7, 3, 3, 'Miami', 'MIM', 1558631553);
INSERT INTO locations (id, parent_id, location_type_id, name, code, created_on) VALUES (8, 4, 3, 'Albany', 'ALB', 1558631553);
INSERT INTO locations (id, parent_id, location_type_id, name, code, created_on) VALUES (9, 4, 3, 'New York City', 'NYC', 1558631553);

DROP TABLE IF EXISTS doctors_profiles;
CREATE TABLE doctors_profiles (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  user_id mediumint(8) unsigned NOT NULL,
  location_id smallint(5) unsigned DEFAULT NULL,
  speciality_id smallint(5) unsigned DEFAULT NULL,
  reg_no varchar(40) NOT NULL,
  description text,
  first_qualification varchar(220) NOT NULL,
  other_qualification text NOT NULL,
  is_mobile tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id,reg_no),
  UNIQUE KEY user_id (user_id),
  UNIQUE KEY reg_no (reg_no),
  KEY location_id (location_id),
  KEY speciality_id (speciality_id),
  CONSTRAINT doctors_profiles_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT doctors_profiles_ibfk_2 FOREIGN KEY (location_id) REFERENCES locations (id) ON DELETE SET NULL,
  CONSTRAINT doctors_profiles_ibfk_3 FOREIGN KEY (speciality_id) REFERENCES doctor_specialities (id) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS appointments;
CREATE TABLE appointments (
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  user_id mediumint(8) unsigned NOT NULL,
  doctor_id mediumint(8) unsigned NOT NULL,
  title varchar(100) NOT NULL,
  message text NOT NULL,
  approved tinyint(1) unsigned NOT NULL DEFAULT '0',
  viewed tinyint(1) unsigned NOT NULL DEFAULT '0',
  created_on int(11) unsigned NOT NULL,
  start_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  end_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  KEY doctor_id (doctor_id),
  CONSTRAINT appointments_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
  CONSTRAINT appointments_ibfk_2 FOREIGN KEY (doctor_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;