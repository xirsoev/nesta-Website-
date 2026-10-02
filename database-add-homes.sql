-- Extra privacy-safe example listings for an existing NESTA database.
-- Metrics are summarized from public Primorsky Krai listings; exact locations
-- and seller details are intentionally omitted. Images in NESTA are illustrative.
SET NAMES utf8mb4;

START TRANSACTION;

-- Redact the exact locations in the six original sample rows, if present.
UPDATE properties SET city='Приморский край',address='Адрес скрыт · примерная локация',description='Демонстрационный вариант квартиры с естественным светом и спокойной отделкой. Параметры и фотографии приведены для примера.' WHERE title='Modern Apartment' AND city='Vladivostok' AND address='Center, Svetlanskaya 45';
UPDATE properties SET city='Приморский край',address='Адрес скрыт · примерная локация',description='Демонстрационный вариант дома у воды с большими окнами и светлыми комнатами. Параметры и фотографии приведены для примера.' WHERE title='Ocean View Residence' AND city='Vladivostok' AND address='Egersheld, Leitenanta Shmidta 11';
UPDATE properties SET city='Приморский край',address='Адрес скрыт · примерная локация',description='Демонстрационный минималистичный дом с садом и просторной общей зоной. Параметры и фотографии приведены для примера.' WHERE title='Minimal House' AND city='Artem' AND address='Zolotaya Dolina 8';
UPDATE properties SET city='Приморский край',address='Адрес скрыт · примерная локация',description='Демонстрационный городской лофт с высокими потолками и открытой планировкой. Параметры и фотографии приведены для примера.' WHERE title='Downtown Loft' AND city='Vladivostok' AND address='Center, Aleutskaya 17';
UPDATE properties SET city='Приморский край',address='Адрес скрыт · примерная локация',description='Демонстрационный семейный дом рядом с зелёной зоной. Параметры и фотографии приведены для примера.' WHERE title='Family Residence' AND city='Ussuriysk' AND address='Parkovaya 23';
UPDATE properties SET city='Приморский край',address='Адрес скрыт · примерная локация',description='Демонстрационная загородная вилла с террасой и приватной территорией. Параметры и фотографии приведены для примера.' WHERE title='Luxury Villa' AND city='Vladivostok' AND address='Sadgorod, Morskaya 6';

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Дом с обновлённой планировкой','В доме провели капитальную реконструкцию и увеличили жилую площадь. Общая площадь — 75,9 м², кухня — 10 м²; участок — 11 соток. Адрес скрыт.','Приморский край','Адрес скрыт · пригород',4650000,75.9,0,'House','https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Дом с обновлённой планировкой');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Современный дом для семьи','Дом построен в 2022 году. Просторный участок — 15 соток — оставляет место для сада, террасы и хозяйственной зоны. Планировка и точное расположение уточняются у продавца.','Приморский край','Адрес скрыт · пригород',4300000,84,0,'House','https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Современный дом для семьи');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Дом после капитального ремонта','Одноэтажный дом после капитального ремонта: пять комнат, отдельная топочная и совмещённый санузел. Участок — 6 соток.','Приморский край','Адрес скрыт · примерная локация',4800000,75,5,'House','https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Дом после капитального ремонта');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Тёплый дом с большим участком','Компактный деревянный дом на участке 35 соток. В описании объявления отмечены крепкий фундамент, печное отопление, летний водопровод и скважина на участке.','Приморский край','Адрес скрыт · загородное направление',1050000,29,0,'House','https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Тёплый дом с большим участком');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Дачный дом с садом','Дом из бруса 2020 года на участке 30 соток. На участке есть электричество и септик; скважину предстоит обустроить. Подойдёт тем, кто хочет пространство для сада и отдыха.','Приморский край','Адрес скрыт · загородное направление',1700000,58,0,'House','https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Дачный дом с садом');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Дом с садом и хозяйственными постройками','Дом площадью 62,8 м² с тремя комнатами и просторным участком 13 соток. В объявлении отмечены сад и хозяйственные постройки.','Приморский край','Адрес скрыт · пригород',3100000,62.8,3,'House','https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Дом с садом и хозяйственными постройками');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Дом с баней, гаражом и мастерской','Дом для круглогодичного проживания площадью 90 м². На участке 8 соток расположены баня, гараж и мастерская; в объявлении указан электрический обогрев.','Приморский край','Адрес скрыт · пригород',6200000,90,0,'House','https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Дом с баней, гаражом и мастерской');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Кирпичный дом рядом с инфраструктурой','Кирпичный дом площадью 71,9 м², построенный в 1985 году, на участке 7 соток. В объявлении отмечено удобное расположение рядом с городской инфраструктурой.','Приморский край','Адрес скрыт · городское направление',5699000,71.9,0,'House','https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Кирпичный дом рядом с инфраструктурой');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Дом с просторным участком','Дом площадью 70,1 м² на участке 14 соток. В описании указаны капитальный ремонт и кухня площадью 11,4 м². Год постройки — 1986.','Приморский край','Адрес скрыт · пригород',5000000,70.1,0,'House','https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Дом с просторным участком');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Просторный двухэтажный дом','Двухэтажный дом площадью 173,8 м² на участке 20 соток. В открытом объявлении указаны четыре изолированные комнаты и брусовые стены; объект находится на завершающем этапе строительства.','Приморский край','Адрес скрыт · пригород',3500000,173.8,4,'House','https://images.unsplash.com/photo-1613490493576-7fde63acd811?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Просторный двухэтажный дом');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Дом под чистовую отделку','Дом площадью 105 м² на участке 7,5 соток. По описанию продавца, основные строительные работы завершены, интерьер можно оформить под себя.','Приморский край','Адрес скрыт · пригород',8500000,105,0,'House','https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Дом под чистовую отделку');

INSERT INTO properties (title,description,city,address,price,area,rooms,type,image,status)
SELECT 'Дом с продуманной планировкой','Дом площадью 118,6 м² на участке 5 соток. Публичное объявление описывает вариант, подготовленный для комфортного круглогодичного проживания.','Приморский край','Адрес скрыт · пригород',13335000,118.6,0,'House','https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80','active'
FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM properties WHERE title='Дом с продуманной планировкой');

COMMIT;
