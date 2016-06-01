CREATE TABLE storage (
  sto_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  sto_name VARCHAR(32) NULL,
  sto_date_creation DATETIME NULL,
  sto_date_update DATETIME NULL,
  PRIMARY KEY(sto_id)
);

CREATE TABLE category (
  cat_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cat_name VARCHAR(100) NULL,
  cat_date_creation DATETIME NULL,
  cat_date_update DATETIME NULL,
  PRIMARY KEY(cat_id)
);

CREATE TABLE movie (
  mov_id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cat_id INTEGER UNSIGNED NOT NULL,
  sto_id INTEGER UNSIGNED NOT NULL,
  mov_title VARCHAR(128) NULL,
  mov_cast TEXT NULL,
  mov_synopsis TEXT NULL,
  mov_path VARCHAR(255) NULL,
  mov_original_title VARCHAR(128) NULL,
  mov_image VARCHAR(255) NULL,
  mov_date_creation DATETIME NULL,
  mov_date_update DATETIME NULL,
  PRIMARY KEY(mov_id),
  INDEX movie_FKIndex1(sto_id),
  INDEX movie_FKIndex2(cat_id)
);


