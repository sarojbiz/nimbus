/*
Navicat PGSQL Data Transfer

Source Server         : BBSM
Source Server Version : 90618
Source Host           : 3.1.104.121:5432
Source Database       : db_ecom_bbsm
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90618
File Encoding         : 65001

Date: 2020-11-05 15:11:49
*/


-- ----------------------------
-- Sequence structure for barcodes_barcode_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."barcodes_barcode_id_seq";
CREATE SEQUENCE "public"."barcodes_barcode_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for categories_category_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."categories_category_id_seq";
CREATE SEQUENCE "public"."categories_category_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for colors_color_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."colors_color_id_seq";
CREATE SEQUENCE "public"."colors_color_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for migrations_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."migrations_id_seq";
CREATE SEQUENCE "public"."migrations_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 16
 CACHE 1;
SELECT setval('"public"."migrations_id_seq"', 16, true);

-- ----------------------------
-- Sequence structure for oauth_clients_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."oauth_clients_id_seq";
CREATE SEQUENCE "public"."oauth_clients_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 2
 CACHE 1;
SELECT setval('"public"."oauth_clients_id_seq"', 2, true);

-- ----------------------------
-- Sequence structure for oauth_personal_access_clients_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."oauth_personal_access_clients_id_seq";
CREATE SEQUENCE "public"."oauth_personal_access_clients_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;
SELECT setval('"public"."oauth_personal_access_clients_id_seq"', 1, true);

-- ----------------------------
-- Sequence structure for products_pdt_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."products_pdt_id_seq";
CREATE SEQUENCE "public"."products_pdt_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 79
 CACHE 1;
SELECT setval('"public"."products_pdt_id_seq"', 79, true);

-- ----------------------------
-- Sequence structure for sizes_size_code_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."sizes_size_code_seq";
CREATE SEQUENCE "public"."sizes_size_code_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."users_id_seq";
CREATE SEQUENCE "public"."users_id_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 3
 CACHE 1;
SELECT setval('"public"."users_id_seq"', 3, true);

-- ----------------------------
-- Table structure for barcodes
-- ----------------------------
DROP TABLE IF EXISTS "public"."barcodes";
CREATE TABLE "public"."barcodes" (
"barcode_id" int4 DEFAULT nextval('barcodes_barcode_id_seq'::regclass) NOT NULL,
"barcode" varchar(100) COLLATE "default" NOT NULL,
"pdt_code" varchar(100) COLLATE "default" NOT NULL,
"color_id" int4,
"size_code" int4,
"price" numeric(10,2),
"created_by" int4,
"updated_by" int4,
"created_at" timestamp(0),
"updated_at" timestamp(0)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of barcodes
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS "public"."categories";
CREATE TABLE "public"."categories" (
"category_id" int4 DEFAULT nextval('categories_category_id_seq'::regclass) NOT NULL,
"category_name" varchar(50) COLLATE "default" NOT NULL,
"parent_category_id" int4 DEFAULT 0 NOT NULL,
"category_image" varchar(255) COLLATE "default",
"category_description" varchar(200) COLLATE "default",
"category_level" int4 DEFAULT 0 NOT NULL,
"category_type" char(255) COLLATE "default",
"created_by" int4,
"updated_by" int4,
"created_at" timestamp(0),
"updated_at" timestamp(0),
"identifier" varchar(255) COLLATE "default",
"category_slug" varchar(255) COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO "public"."categories" VALUES ('1', 'Mother & Baby', '0', null, 'Lorem ipsum dolor sit amet, a neque praesent, ultrices porta et', '1', 'G                                                                                                                                                                                                                                                              ', '1', '1', '2020-06-18 06:23:55', '2020-07-07 14:46:03', 'a652b362676a8ee5b96582bfa31b99ff', 'mother-baby');
INSERT INTO "public"."categories" VALUES ('2', 'Diapering & Potty', '1', null, 'Lorem ipsum dolor sit amet, a neque praesent, ultrices porta et', '1', 'G                                                                                                                                                                                                                                                              ', '1', '1', '2020-06-18 06:23:55', '2020-07-07 14:46:42', 'c2f02dd65031db046badb4615017d485', 'diapering-potty');
INSERT INTO "public"."categories" VALUES ('3', 'Disposable Diapers', '2', null, 'Lorem ipsum dolor sit amet, a neque praesent, ultrices porta et', '1', 'A                                                                                                                                                                                                                                                              ', '1', '1', '2020-06-18 06:23:56', '2020-07-07 14:46:54', '727c983ac0d97f7e7268ff6970a69c05', 'disposable-diapers');

-- ----------------------------
-- Table structure for colors
-- ----------------------------
DROP TABLE IF EXISTS "public"."colors";
CREATE TABLE "public"."colors" (
"color_id" int4 DEFAULT nextval('colors_color_id_seq'::regclass) NOT NULL,
"color_name" varchar(50) COLLATE "default" NOT NULL,
"created_by" int4,
"updated_by" int4,
"created_at" timestamp(0),
"updated_at" timestamp(0)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of colors
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS "public"."migrations";
CREATE TABLE "public"."migrations" (
"id" int4 DEFAULT nextval('migrations_id_seq'::regclass) NOT NULL,
"migration" varchar(255) COLLATE "default" NOT NULL,
"batch" int4 NOT NULL
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO "public"."migrations" VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO "public"."migrations" VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO "public"."migrations" VALUES ('3', '2016_06_01_000001_create_oauth_auth_codes_table', '1');
INSERT INTO "public"."migrations" VALUES ('4', '2016_06_01_000002_create_oauth_access_tokens_table', '1');
INSERT INTO "public"."migrations" VALUES ('5', '2016_06_01_000003_create_oauth_refresh_tokens_table', '1');
INSERT INTO "public"."migrations" VALUES ('6', '2016_06_01_000004_create_oauth_clients_table', '1');
INSERT INTO "public"."migrations" VALUES ('7', '2016_06_01_000005_create_oauth_personal_access_clients_table', '1');
INSERT INTO "public"."migrations" VALUES ('12', '2020_05_22_170522_create_sizes_table', '2');
INSERT INTO "public"."migrations" VALUES ('13', '2020_05_24_060203_create_colors_table', '2');
INSERT INTO "public"."migrations" VALUES ('14', '2020_05_24_061255_create_categories_table', '2');
INSERT INTO "public"."migrations" VALUES ('15', '2020_05_29_040229_create_products_table', '2');
INSERT INTO "public"."migrations" VALUES ('16', '2020_06_03_090326_create_barcodes_table', '2');

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_access_tokens";
CREATE TABLE "public"."oauth_access_tokens" (
"id" varchar(100) COLLATE "default" NOT NULL,
"user_id" int8,
"client_id" int4 NOT NULL,
"name" varchar(255) COLLATE "default",
"scopes" text COLLATE "default",
"revoked" bool NOT NULL,
"created_at" timestamp(0),
"updated_at" timestamp(0),
"expires_at" timestamp(0)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of oauth_access_tokens
-- ----------------------------
INSERT INTO "public"."oauth_access_tokens" VALUES ('11d024c0e247fe9991018c20d2e46631426ec00b9a83e017de0318b7418bce472f1f45d2e7aaad5c', '1', '1', 'authToken', '[]', 'f', '2020-07-03 19:13:08', '2020-07-03 19:13:08', '2021-07-03 19:13:08');
INSERT INTO "public"."oauth_access_tokens" VALUES ('320c7bf260885201f53a3fb99896e98e064f74ce59cb9a91f5f43b94310523e528bfc1f657f590f4', '3', '1', 'authToken', '[]', 'f', '2020-05-29 10:22:43', '2020-05-29 10:22:43', '2021-05-29 10:22:43');
INSERT INTO "public"."oauth_access_tokens" VALUES ('3b9ff3487b9fd1fc6496bf5d508c15488170f4234097e38ec707e3c6beb05ac1152c5cbf4b9a536c', '1', '1', 'authToken', '[]', 'f', '2020-06-03 07:55:49', '2020-06-03 07:55:49', '2021-06-03 07:55:49');
INSERT INTO "public"."oauth_access_tokens" VALUES ('47d1d2934f48f3c19ae03ddef34e9bf9048a24b7100772c2da64f0f050a00283562b88403707f9be', '1', '1', 'authToken', '[]', 'f', '2020-06-01 06:01:00', '2020-06-01 06:01:00', '2021-06-01 06:01:00');
INSERT INTO "public"."oauth_access_tokens" VALUES ('4aa84e96d19bebdf2bd32ec7dac06f8a13f12ad009b9006f8351fec578c62da8d4e4a81abd6c9ebf', '3', '1', 'authToken', '[]', 'f', '2020-05-29 10:23:02', '2020-05-29 10:23:02', '2021-05-29 10:23:02');
INSERT INTO "public"."oauth_access_tokens" VALUES ('4ee3ed780c514871b319dd40dee8023e8afd4016a4c73ebeafdbaabbce2bf54b7c8eb28667fca1c4', '1', '1', 'authToken', '[]', 'f', '2020-06-24 12:57:36', '2020-06-24 12:57:36', '2021-06-24 12:57:36');
INSERT INTO "public"."oauth_access_tokens" VALUES ('5c7949a7420951f64b731a2a9a7515f07393dbf3c6c1f487263b543cc1b6c94233b588af0a76fad6', '1', '1', 'authToken', '[]', 'f', '2020-06-11 06:46:06', '2020-06-11 06:46:06', '2021-06-11 06:46:06');
INSERT INTO "public"."oauth_access_tokens" VALUES ('6cbf095bd6e6a9406a1595374e59b6735e0e5f0a401c122f44c71af38f2175c32258c00a3f3b7419', '1', '1', 'authToken', '[]', 'f', '2020-05-26 10:56:34', '2020-05-26 10:56:34', '2021-05-26 10:56:34');
INSERT INTO "public"."oauth_access_tokens" VALUES ('98bd19e80c77b90888065ccc94f04049a73f3e4b25ea083ce60f445b9e0a0299968bf9d3e5e6bb16', '1', '1', 'authToken', '[]', 'f', '2020-05-27 07:31:47', '2020-05-27 07:31:47', '2021-05-27 07:31:47');
INSERT INTO "public"."oauth_access_tokens" VALUES ('b4f55ff186c34f84d1036a13cc492ad8652f8a5b68a83ade8e2be76069a431dc97cb567d5725f679', '1', '1', 'authToken', '[]', 'f', '2020-06-01 05:53:54', '2020-06-01 05:53:54', '2021-06-01 05:53:54');
INSERT INTO "public"."oauth_access_tokens" VALUES ('db387d2ed42ea9c03c61f836e251dfb16403a697c795a3cac0bbc2837c8b671640572a779bbed1b6', '2', '1', 'authToken', '[]', 'f', '2020-05-27 07:55:58', '2020-05-27 07:55:58', '2021-05-27 07:55:58');
INSERT INTO "public"."oauth_access_tokens" VALUES ('dd11fe4679ec60c314bc24e26f885b1a05876faffa5068c7c529669b411952f83b89bdab74991436', '1', '1', 'authToken', '[]', 'f', '2020-05-26 11:24:02', '2020-05-26 11:24:02', '2021-05-26 11:24:02');
INSERT INTO "public"."oauth_access_tokens" VALUES ('f4d39e80fce3e743497a4488b769cd3b6cbe32a1b7e22883a04ae3bd44711fc5640a0203b55c51b6', '1', '1', 'authToken', '[]', 'f', '2020-05-26 10:41:32', '2020-05-26 10:41:32', '2021-05-26 10:41:32');

-- ----------------------------
-- Table structure for oauth_auth_codes
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_auth_codes";
CREATE TABLE "public"."oauth_auth_codes" (
"id" varchar(100) COLLATE "default" NOT NULL,
"user_id" int8 NOT NULL,
"client_id" int4 NOT NULL,
"scopes" text COLLATE "default",
"revoked" bool NOT NULL,
"expires_at" timestamp(0)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of oauth_auth_codes
-- ----------------------------

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_clients";
CREATE TABLE "public"."oauth_clients" (
"id" int4 DEFAULT nextval('oauth_clients_id_seq'::regclass) NOT NULL,
"user_id" int8,
"name" varchar(255) COLLATE "default" NOT NULL,
"secret" varchar(100) COLLATE "default" NOT NULL,
"redirect" text COLLATE "default" NOT NULL,
"personal_access_client" bool NOT NULL,
"password_client" bool NOT NULL,
"revoked" bool NOT NULL,
"created_at" timestamp(0),
"updated_at" timestamp(0)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of oauth_clients
-- ----------------------------
INSERT INTO "public"."oauth_clients" VALUES ('1', null, 'Laravel Personal Access Client', 'wbpmGsZIKoEPLBueVbVJpciO1qqOYBCAOwvRcJyW', 'http://localhost', 't', 'f', 'f', '2020-05-26 10:13:55', '2020-05-26 10:13:55');
INSERT INTO "public"."oauth_clients" VALUES ('2', null, 'Laravel Password Grant Client', 'cUpcGyaPEZuWHVZIuWSU5W0kCzMIhaTe8LhwLWWZ', 'http://localhost', 'f', 't', 'f', '2020-05-26 10:13:55', '2020-05-26 10:13:55');

-- ----------------------------
-- Table structure for oauth_personal_access_clients
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_personal_access_clients";
CREATE TABLE "public"."oauth_personal_access_clients" (
"id" int4 DEFAULT nextval('oauth_personal_access_clients_id_seq'::regclass) NOT NULL,
"client_id" int4 NOT NULL,
"created_at" timestamp(0),
"updated_at" timestamp(0)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of oauth_personal_access_clients
-- ----------------------------
INSERT INTO "public"."oauth_personal_access_clients" VALUES ('1', '1', '2020-05-26 10:13:55', '2020-05-26 10:13:55');

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_refresh_tokens";
CREATE TABLE "public"."oauth_refresh_tokens" (
"id" varchar(100) COLLATE "default" NOT NULL,
"access_token_id" varchar(100) COLLATE "default" NOT NULL,
"revoked" bool NOT NULL,
"expires_at" timestamp(0)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of oauth_refresh_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS "public"."password_resets";
CREATE TABLE "public"."password_resets" (
"email" varchar(255) COLLATE "default" NOT NULL,
"token" varchar(255) COLLATE "default" NOT NULL,
"created_at" timestamp(0)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS "public"."products";
CREATE TABLE "public"."products" (
"pdt_id" int4 DEFAULT nextval('products_pdt_id_seq'::regclass) NOT NULL,
"mcode" varchar(50) COLLATE "default" NOT NULL,
"pdt_code" varchar(50) COLLATE "default" NOT NULL,
"inventory_sku" numeric(10,5) DEFAULT '0'::numeric NOT NULL,
"pdt_name" varchar(255) COLLATE "default",
"pdt_short_description" varchar(255) COLLATE "default",
"pdt_long_description" text COLLATE "default",
"category_code" int4 DEFAULT 0 NOT NULL,
"pdt_brand" varchar(50) COLLATE "default",
"regular_price" numeric(10,2),
"measurement_unit" varchar(50) COLLATE "default",
"has_size_color" bool DEFAULT false NOT NULL,
"is_feature_product" bool DEFAULT false NOT NULL,
"is_sale_product" bool DEFAULT false NOT NULL,
"stock_status" varchar(255) COLLATE "default" DEFAULT 'instock'::character varying NOT NULL,
"feature_image" varchar(255) COLLATE "default",
"gallery_images" json,
"created_by" int4,
"updated_by" int4,
"created_at" timestamp(0),
"updated_at" timestamp(0),
"product_status" int2 DEFAULT 1,
"identifier" varchar(255) COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO "public"."products" VALUES ('1', 'M100401', '120.105', '120.10500', 'GLORISOX LADY SOCKS CS-65', 'GLORISOX LADY SOCKS CS-65', '<p><span style="background-color: #ffffff;">GLORISOX LADY SOCKS CS-65</span></p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17c8c70e.jpg', null, '1', null, '2020-06-07 04:53:25', '2020-07-05 16:39:52', '1', '9844c31e1db1b320893370973591c9c2');
INSERT INTO "public"."products" VALUES ('2', 'M101044', '133.23', '133.23000', 'EMBIDOREY SAREE A-3360', 'EMBIDOREY SAREE A-3360', '<p><span style="background-color: #ffffff;">EMBIDOREY SAREE A-3360</span></p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17c95c3f.jpg', null, '1', null, '2020-06-07 04:57:09', '2020-07-05 16:39:52', '1', 'c10998c041a011293fee7bd1d32f69e5');
INSERT INTO "public"."products" VALUES ('3', '100015', 'M100015', '27.17700', 'MOLFIX BABY DIAPERS 3 MIDI 25-PCS 3-2', 'Lorem ipsum dolor sit amet, a neque praesent, ultrices porta et', '<p>New cons</p>\n\n<p>She wants to cons with doctor for acne,&nbsp;&nbsp;pores &nbsp;and&nbsp; stretch mark&nbsp;&nbsp;problem</p>\n\n<p>Phone call on 25th April 2020, she didnt answer the call, connected via Khushaboo&#39;s number, no medication prescribed. Patient needs to visit after the lockdown.</p>\n', '3', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', null, '["M10094_1.jpg"]', '1', null, '2020-06-11 06:46:18', '2020-07-05 16:39:52', '1', '03eefc6b5dc4d337ac6bb32136373877');
INSERT INTO "public"."products" VALUES ('4', 'M10094', '21.198', '21.19800', 'CADBURY BOURN VITA 1KG JAR-IC-370', 'Bourn Vita', '<p><strong><span style="background-color: #ffffff;">CADBURY BOURN VITA 1KG JAR-IC-370</span></strong></p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17c9fad0.jpg', '["M10094_1.jpg"]', '1', null, '2020-06-11 07:31:05', '2020-07-05 16:39:52', '1', '13c4e81481afa51d4eef18a8a77227b1');
INSERT INTO "public"."products" VALUES ('5', 'M100402', '120.106', '120.10600', 'APEY BABY SOCKS CS-55', 'apple', '<ul>
<li><span style="background-color: #ffffff;">APEY BABY SOCKS CS-55</span></li>
</ul>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', null, '[]', '1', null, '2020-06-17 04:50:34', '2020-07-05 16:39:52', '1', '46613f443e00bf03d067e0222a169bcd');
INSERT INTO "public"."products" VALUES ('6', 'M100424', '120.117', '120.11700', 'NUNU BABY SOCKS CS-45', 'NUNU BABY SOCKS CS-45', '<p>NUNU BABY SOCKS CS-45</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', null, '[]', '1', null, '2020-06-17 05:16:39', '2020-07-05 16:39:52', '1', '42f87b536b571bb9bb67794f2939a068');
INSERT INTO "public"."products" VALUES ('7', 'M10010', '88.78', '88.78000', 'JOHN PLAYERS MENS PANT JP-2500', 'OHN PLAYERS MENS PANT JP-2500', '<p>OHN PLAYERS MENS PANT JP-2500</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17cad206.jpg', '["M10010_1.webp","M10010_2.jpg"]', '1', null, '2020-06-17 05:23:15', '2020-07-05 16:39:52', '1', '2304a65619854b60ded4f41b02e7243f');
INSERT INTO "public"."products" VALUES ('8', 'M121880', '121.33', '121.33000', 'APPLE BRAND LADY FULL SWEATER 102', 'Apple', '<ul>
<li><strong>APPLE BRAND LADY FULL SWEATER 102</strong></li>
</ul>
<p><strong>ladies Jacket(cardigan)</strong></p>', '1', null, '2.00', 'PC', 'f', 't', 'f', 'instock', '5f01b17cb4b27.jpg', '[]', '1', null, '2020-06-17 05:28:51', '2020-07-05 16:39:52', '1', '540052fe50eeb2589cb83565b21e0cd6');
INSERT INTO "public"."products" VALUES ('9', 'M100403', '120.107', '120.10700', 'APEY BABY SOCKS CS-50', 'babysocks', '<p>babysocks</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17cc39cd.jpg', '[]', '1', null, '2020-06-17 05:30:37', '2020-07-05 16:39:52', '1', '292887f75c9c9469f219d140a9df3bda');
INSERT INTO "public"."products" VALUES ('10', 'M100581P', '211.134', '211.13400', 'BED SHEET VELVET PLAIN SINGLE ME-1322.5', 'bed shee', '<p><em><span style="background-color: #ffffff;">BED SHEET VELVET PLAIN SINGLE ME-1322.5</span></em></p>
<p>&nbsp;</p>
<p><em><span style="background-color: #ffffff;">bed sheet ludo</span></em></p>
<p><em><span style="background-color: #ffffff;">bed sheet blue</span></em></p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17ccfdd7.jpg', '["M100581P_1.jpg"]', '1', null, '2020-06-17 05:32:00', '2020-07-05 16:39:52', '1', '1a76191638f6b2c9ce2e4e20f729c4b1');
INSERT INTO "public"."products" VALUES ('11', 'M100986', '120.125', '120.12500', 'BB BABY 2PCS SET 9-360/9-362/9-460/9-358', null, '<p>bb baby</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17cde273.jpg', '[]', '1', null, '2020-06-17 05:33:10', '2020-07-05 16:39:52', '1', 'f77d75fd1c0c8e21dd1892c5a4de05e8');
INSERT INTO "public"."products" VALUES ('12', 'M101096', '139.7', '139.70000', 'BOLKARY LADY SHAWL BS-225', 'Shawl', '<p>beautiful shawl made from sheep fur and dyed in deep himalayan mountains with dye made from Yak fluids</p>', '1', null, '2.00', 'PC', 'f', 't', 't', 'instock', '5f01b17ce9cbc.jpg', '[]', '1', null, '2020-06-17 05:35:15', '2020-07-05 16:39:53', '1', '22758de430a304f3c889cbcf2ed7a1ea');
INSERT INTO "public"."products" VALUES ('13', 'M1010', '114.125', '114.12500', 'CHLOE LADY CLOSE SHOES N771A', 'ladyshoes', '<p>white shoes</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d03009.jpg', '[]', '1', null, '2020-06-17 05:37:55', '2020-07-05 16:39:53', '1', 'aa3b6d50a7ed91eddad092d3b008a3ee');
INSERT INTO "public"."products" VALUES ('14', 'M10043', '78.19', '78.19000', 'DEMODE LADY FULL T-SHIRT RG-415', null, '<p>lady tshirt</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', null, '[]', '1', null, '2020-06-17 05:38:46', '2020-07-05 16:39:53', '1', '47ae96a84b0c6350c8ca89a9ed1ea100');
INSERT INTO "public"."products" VALUES ('15', 'M10045', '97.30', '97.30000', 'DNCOME MENS HALF SWEATER HS-7', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d0f063.jpg', '[]', '1', null, '2020-06-17 05:42:08', '2020-07-05 16:39:53', '1', 'b031d6c1daadf22b5bb0d5bcfbee11fc');
INSERT INTO "public"."products" VALUES ('16', 'M100877P', '211.135', '211.13500', 'DOURSET DOUBLE ME-4203', null, '<p>Dorset double bed double joint</p>', '1', null, '2.00', 'PC', 'f', 'f', 't', 'instock', '5f01b17d1c231.jpg', '[]', '1', null, '2020-06-17 05:44:36', '2020-07-05 16:39:53', '1', '7a48f364e3ef4ce648e7f4008358aaae');
INSERT INTO "public"."products" VALUES ('17', 'M100920', '102.55', '102.55000', 'DUMBELL 5LB WEIGHT', 'dumbells 5 LB', '<p>Dumbell Fitby range</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d24d10.jpg', '[]', '1', null, '2020-06-17 05:46:32', '2020-07-05 16:39:53', '1', 'e32bfc93830b07db4e51dc042ea469a5');
INSERT INTO "public"."products" VALUES ('18', 'M100983', '120.124', '120.12400', 'D BEAR BABY 2PCS SET 8143/8221/8217', 'babybear', '<p>teddy bear for the single couples with or withouot baby</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d2c8c8.jpg', '[]', '1', null, '2020-06-17 05:49:44', '2020-07-05 16:39:53', '1', '163f8b40fbd0208832e8a3bf0f432322');
INSERT INTO "public"."products" VALUES ('19', 'M101045', '133.24', '133.24000', 'EMBIDOREY SAREE A-3700', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d37e2c.jpg', '["M101045_1.jpg"]', '1', null, '2020-06-17 05:51:45', '2020-07-05 16:39:53', '1', '5c0c8185ec1cdbaec9f355f3a9898cd9');
INSERT INTO "public"."products" VALUES ('20', 'M101046', '133.25', '133.25000', 'EMBIDOREY SAREE A-4750', null, null, '1', null, '2.00', 'PC', 'f', 'f', 't', 'instock', '5f01b17d41734.jpg', '[]', '1', null, '2020-06-17 05:52:30', '2020-07-05 16:39:53', '1', 'ab96e3077403e8fe06a3cf95f1f4376b');
INSERT INTO "public"."products" VALUES ('21', 'M101047', '133.26', '133.26000', 'EMBIDOREY SAREE A-4025', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d50a7a.jpg', '[]', '1', null, '2020-06-17 05:53:28', '2020-07-05 16:39:53', '1', 'cbac24d07728f7fe551d8ab83b5d9b8c');
INSERT INTO "public"."products" VALUES ('22', 'M10079', '74.164', '74.16400', 'FADED GLORY BABY JEANS PANT BN-375', 'pants4baby', '<p>baby pants</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d602d9.jpg', '[]', '1', null, '2020-06-17 05:54:21', '2020-07-05 16:39:53', '1', '7e77e8cfd82bf8c228efcbab35d833a5');
INSERT INTO "public"."products" VALUES ('23', 'M101042', '133.22', '133.22000', 'FRENCH EMBIDOREY SAREE A-9250', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d69d94.jpg', '[]', '1', null, '2020-06-17 05:56:37', '2020-07-05 16:39:53', '1', '194e8eab37c14dd72cd2b06408fbfcda');
INSERT INTO "public"."products" VALUES ('24', 'M101048', '133.27', '133.27000', 'FRENCH EMBIDOREY SAREE A-6750', null, '<p>Embroidary sareee</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d72bce.jpg', '[]', '1', null, '2020-06-17 05:57:37', '2020-07-05 16:39:53', '1', 'f9e8edb0f36a050897719fb71f5dd373');
INSERT INTO "public"."products" VALUES ('25', 'M100166P', '749.187', '749.18700', 'HARMONY CARPET 67*120CM ME-1903', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d822b0.jpg', '[]', '1', null, '2020-06-17 06:00:20', '2020-07-05 16:39:53', '1', '7e5c0f1cccb8512cd98928a379b7da78');
INSERT INTO "public"."products" VALUES ('26', 'M100167P', '749.188', '749.18800', 'HARMONY CARPET 100*150CM ME-3628', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d930f0.jpg', '[]', '1', null, '2020-06-17 06:00:55', '2020-07-05 16:39:53', '1', '39c9a3af4cfde6221936f0210f5b7e94');
INSERT INTO "public"."products" VALUES ('27', 'M100168P', '749.189', '749.18900', 'HARMONY CARPET 133*190CM ME-5973', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17d9cb89.jpg', '[]', '1', null, '2020-06-17 06:01:26', '2020-07-05 16:39:53', '1', '312e42a8e0b3c6f77f4ac40ee875c0b0');
INSERT INTO "public"."products" VALUES ('28', 'M1008', '52.104', '52.10400', 'HERO CUP WATER BOTTLE 900ML JL-1016', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17da4a6c.jpg', '[]', '1', null, '2020-06-17 06:09:47', '2020-07-05 16:39:53', '1', '81dc2eb2623c98ff711b436889ffd9e9');
INSERT INTO "public"."products" VALUES ('29', 'M10108', '26.190', '26.19000', 'HARMONY HAIR SPRAY EXTRA FIRM HOLD 300ML', 'Spray4hair', '<p>Firm hair spray</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17db94f0.jpg', '[]', '1', null, '2020-06-17 06:11:05', '2020-07-05 16:39:53', '1', '2c69c24c7ae338dee020eff018c77018');
INSERT INTO "public"."products" VALUES ('30', 'M100863', '89.104', '89.10400', 'INTER CREW MENS THICK SOCKS SA-125', 'Socks4men', '<p>Men socks</p>', '1', null, '2.00', 'PC', 'f', 'f', 't', 'instock', '5f01b17dc294f.jpg', '[]', '1', null, '2020-06-17 06:11:56', '2020-07-05 16:39:53', '1', 'f3f2009aa43918190f5e1068f4ed8947');
INSERT INTO "public"."products" VALUES ('31', 'M100417', '120.111', '120.11100', 'JIA TING LADY GLOVES CS-140', 'lady gloves', '<p>A <strong>glove</strong> is a <a class="mw-redirect" title="Garment" href="https://en.wikipedia.org/wiki/Garment">garment</a> covering the whole <a title="Hand" href="https://en.wikipedia.org/wiki/Hand">hand</a>. Gloves usually have separate sheaths or openings for each <a title="Finger" href="https://en.wikipedia.org/wiki/Finger">finger</a> and the <a title="Thumb" href="https://en.wikipedia.org/wiki/Thumb">thumb</a>.</p>
<p>If there is an opening but no (or a short) covering sheath for each finger they are called <strong>fingerless gloves</strong>. Fingerless gloves having one small opening rather than individual openings for each finger are sometimes called <a title="Gauntlet (glove)" href="https://en.wikipedia.org/wiki/Gauntlet_(glove)">gauntlets</a>, though gauntlets are not necessarily fingerless.</p>
<p>Gloves which cover the entire hand or fist but do not have separate finger openings or sheaths are called <strong>mittens</strong>. Mittens are warmer than other styles of gloves made of the same material because fingers maintain their warmth better when they are in contact with each other; reduced surface area reduces <a title="Heat" href="https://en.wikipedia.org/wiki/Heat">heat</a> loss.</p>
<p>A hybrid of glove and mitten contains open-ended sheaths for the four fingers (as in a fingerless glove, but not the thumb) and an additional compartment encapsulating the four fingers. This compartment can be lifted off the fingers and folded back to allow the individual fingers ease of movement and access while the hand remains covered. The usual design is for the mitten cavity to be stitched onto the back of the fingerless glove only, allowing it to be flipped over (normally held back by <a title="Velcro" href="https://en.wikipedia.org/wiki/Velcro">Velcro</a> or a button) to transform the garment from a mitten to a glove. These hybrids are called convertible mittens or glittens, a combination of "glove" and "mittens".</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17dcf3df.jpg', '[]', '1', null, '2020-06-17 06:14:11', '2020-07-05 16:39:53', '1', '2b884637b8f04625f6826979eeee8ff3');
INSERT INTO "public"."products" VALUES ('32', 'M10075', '84.103', '84.10300', 'JOCKEY SPORT MENS SANDO 9930 (850035)', null, '<p>sando for men</p>
<p>black</p>
<p>blue</p>
<p>yellow</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17dd6ec6.jpg', '[]', '1', null, '2020-06-17 06:15:07', '2020-07-05 16:39:53', '1', 'ba74e87002fed7f351eced555921df03');
INSERT INTO "public"."products" VALUES ('33', 'M100979', '120.123', '120.12300', 'KU.GU BABY 3PCS SET 9850/9777', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17de2106.jpg', '[]', '1', null, '2020-06-17 06:16:01', '2020-07-05 16:39:53', '1', '900fcc1c191d8f92eb82c9893f48d8ee');
INSERT INTO "public"."products" VALUES ('34', 'M10031', '94.57', '94.57000', 'LOBITO MENS PARTY SHOES 9233', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17df0180.jpg', '[]', '1', null, '2020-06-17 06:17:59', '2020-07-05 16:39:54', '1', 'c50b3571bdac78c79bf47e3a98ee8dbb');
INSERT INTO "public"."products" VALUES ('35', 'M100409', '120.108', '120.10800', 'LEG LIFE LADY SOCKS CS-80', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17e07ae0.jpg', '[]', '1', null, '2020-06-17 06:18:41', '2020-07-05 16:39:54', '1', '7e9ca3fc2cb9b4ed1c12895c28a0373b');
INSERT INTO "public"."products" VALUES ('36', 'M100427', '120.119', '120.11900', 'LADY WOOLEN CAP CS-225', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17e12f27.jpg', '[]', '1', null, '2020-06-17 06:19:49', '2020-07-05 16:39:54', '1', 'cdb6e23c452f9bda259597dcaf600f7d');
INSERT INTO "public"."products" VALUES ('37', 'M100428', '120.120', '120.12000', 'LADY WOOLEN CAP CS-175', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17e21f86.jpg', '[]', '1', null, '2020-06-17 06:20:22', '2020-07-05 16:39:54', '1', '2af98f5b38bfde060f2a37ff3981e1a9');
INSERT INTO "public"."products" VALUES ('38', 'M100530P', '764.155', '764.15500', 'LEE MENS JEANS PANT L37933248147', null, null, '1', null, '2.00', 'PC', 'f', 't', 't', 'instock', '5f01b17e2f89d.jpg', '[]', '1', null, '2020-06-17 06:24:19', '2020-07-05 16:39:54', '1', '9c50ab8b7ea84576d41c78dbb6bd9c95');
INSERT INTO "public"."products" VALUES ('39', 'M100535P', '764.159', '764.15900', 'LEE MENS CAP L382593661MV', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17e3cd69.jpg', '[]', '1', null, '2020-06-17 06:28:23', '2020-07-05 16:39:54', '1', 'b40ff371f41e1c9a6db5d935c03b509b');
INSERT INTO "public"."products" VALUES ('40', 'M100537P', '764.160', '764.16000', 'LEE MENS FULL JACKET L38786AA4W64', null, '<p>Jacket for men <br />no fur <br />no Tear<br />no wear</p>', '1', null, '2.00', 'PC', 'f', 'f', 't', 'instock', '5f01b17e4916d.jpg', '[]', '1', null, '2020-06-17 06:33:16', '2020-07-05 16:39:54', '1', '140f8b0f163d363b80b103a918311c62');
INSERT INTO "public"."products" VALUES ('41', 'M100539P', '764.161', '764.16100', 'LEE MENS FULL JACKET L38787AA4Z22', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17e54fb1.jpg', '["M100539P_1.jpg","M100539P_2.jpg"]', '1', null, '2020-06-17 06:34:39', '2020-07-05 16:39:54', '1', 'e07a2becc70824575e1f6460646a24d5');
INSERT INTO "public"."products" VALUES ('42', 'M100540P', '764.162', '764.16200', 'LEE MENS FULL JACKET L38788AA4Z43', null, '<p>Brown <br />white</p>
<p>&nbsp;</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17e61f2b.jpg', '["M100540P_1.jpg","M100540P_2.jpg"]', '1', null, '2020-06-17 06:35:50', '2020-07-05 16:39:54', '1', '6dc6bd438756923f02686987d4cd0d3e');
INSERT INTO "public"."products" VALUES ('43', 'M100541P', '764.163', '764.16300', 'LEE MENS FULL T-SHIRT L38654CBOF77', null, '<p>Anarchy</p>
<p>&nbsp;</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17e6dc7e.jpg', '["M100541P_1.jpg","M100541P_2.webp"]', '1', null, '2020-06-17 06:37:02', '2020-07-05 16:39:54', '1', '1415d9fb8df6f7d1c1602407a296f2bd');
INSERT INTO "public"."products" VALUES ('44', 'M100542P', '764.164', '764.16400', 'LEE MENS FULL T-SHIRT L38695CBOG1M', 'one pair', '<p>Limited anarchy t shirts worn by Real anarchist</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', null, '[]', '1', null, '2020-06-17 06:37:51', '2020-07-05 16:39:54', '1', 'b6cf45a1b225326a8acfe31924c52de3');
INSERT INTO "public"."products" VALUES ('45', 'M10107', '111.83', '111.83000', 'LOBITO MENS LEATHER SHOES 8128', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17e7afc9.jpg', '[]', '1', null, '2020-06-17 06:38:21', '2020-07-05 16:39:54', '1', 'dde4ef5bb24a7a4efe064501b5b4d055');
INSERT INTO "public"."products" VALUES ('46', 'M101090', '139.2', '139.20000', 'LADY SHAWL BS-180', null, '<p>Lady shawl to be gifted to wife</p>', '1', null, '2.00', 'PC', 'f', 'f', 't', 'instock', null, '[]', '1', null, '2020-06-17 06:39:53', '2020-07-05 16:39:54', '1', '1735f5396ec960c7e56be175627fd3ff');
INSERT INTO "public"."products" VALUES ('47', 'M101094', '139.5', '139.50000', 'LADY SHAWL BS-205', 'Shawls', '<p>Lady shawls for Girlfirends</p>', '1', null, '2.00', 'PC', 'f', 't', 't', 'instock', '5f01b17e8310a.jpg', '["M101094_1.jpg"]', '1', null, '2020-06-17 06:40:38', '2020-07-05 16:39:54', '1', 'eeba96d643081bde4b5333b474572098');
INSERT INTO "public"."products" VALUES ('48', 'M101095', '139.6', '139.60000', 'LADY SHAWL BS-150', null, '<p>Lady shawls for Teens</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17e93fb1.jpg', '[]', '1', null, '2020-06-17 06:41:20', '2020-07-05 16:39:54', '1', '60a675bca538bb6dc482692666c0feca');
INSERT INTO "public"."products" VALUES ('49', 'M101098', '139.9', '139.90000', 'LADY SHAWL BS-225', null, '<p>lady shawls</p>', '1', null, '2.00', 'PC', 'f', 'f', 't', 'instock', null, '[]', '1', null, '2020-06-17 06:42:10', '2020-07-05 16:39:54', '1', '3ba17461bf110d81ca0e33aac81da466');
INSERT INTO "public"."products" VALUES ('50', 'M100010', '27.177', '27.17700', 'MOLFIX BABY DIAPERS 3 MIDI 25-PCS', null, '<p>Diapers for non adults</p>
<p>&nbsp;</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17ea2cb9.jpg', '[]', '1', null, '2020-06-17 06:44:09', '2020-07-05 16:39:54', '1', 'b9c23005d0d47dbc2b0e9b3db8f2482d');
INSERT INTO "public"."products" VALUES ('51', 'M100011', '27.178', '27.17800', 'MOLFIX BABY DIAPERS 4 MAXI 22-PCS', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17eaa78c.jpg', '[]', '1', null, '2020-06-17 06:44:48', '2020-07-05 16:39:54', '1', 'ece2d508f23e32b61192f13cce724007');
INSERT INTO "public"."products" VALUES ('52', 'M100013', '27.179', '27.17900', 'MOLFIX BABY DIAPERS 4 MAXI PLUS 19-PCS', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17eb7a2f.jpg', '["M100013_1.jpg"]', '1', null, '2020-06-17 06:45:29', '2020-07-05 16:39:54', '1', 'baadd57d236eaa23a8aaf17e44ed828b');
INSERT INTO "public"."products" VALUES ('53', 'M100016', '27.181', '27.18100', 'MOLFIX BABY DIAPERS 2 MINI 66-PCS', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17ebf4cf.jpg', '[]', '1', null, '2020-06-17 06:47:26', '2020-07-05 16:39:54', '1', 'fd9b54a759195023086ea5fc238c750c');
INSERT INTO "public"."products" VALUES ('54', 'M100017', '27.182', '27.18200', 'MOLFIX BABY DIAPERS 3 MIDI 50-PCS', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17ec6edc.jpg', '[]', '1', null, '2020-06-17 06:49:10', '2020-07-05 16:39:54', '1', '625dbc8036073d9ec94a559c8e23de5f');
INSERT INTO "public"."products" VALUES ('55', 'M100022', '27.185', '27.18500', 'MOLFIX BABY DIAPERS 5 JUNIOR 32-PCS', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17ed4d46.jpg', '[]', '1', null, '2020-06-17 06:50:08', '2020-07-05 16:39:54', '1', 'ee1c0f29c3c7a5df5186dc8c75f1a195');
INSERT INTO "public"."products" VALUES ('56', 'M10035P', '753.24', '753.24000', 'MY FIRST BABY 3PCS SET 2240/2241/2242', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17ee20cc.jpg', '[]', '1', null, '2020-06-17 06:50:59', '2020-07-05 16:39:54', '1', '4d4c36569fae02d416531891f9e78002');
INSERT INTO "public"."products" VALUES ('57', 'M10020P', '722.128', '722.12800', 'MONTE CARLO MENS HALF T-SHIRT NWH-1904', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17eeb061.jpg', '[]', '1', null, '2020-06-17 06:51:59', '2020-07-05 16:39:55', '1', 'a01122ce2634d2f1a234dfeaf2e5fd74');
INSERT INTO "public"."products" VALUES ('58', 'M100687', '116.54', '116.54000', 'MONTE CARLO MENS HALF SWEATER DT-1230', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f04aa8.jpg', '[]', '1', null, '2020-06-17 06:52:56', '2020-07-05 16:39:55', '1', '3866367b13c7968cdadd93e18fb51f17');
INSERT INTO "public"."products" VALUES ('59', 'M100688', '116.55', '116.55000', 'MONTE CARLO MENS HALF SWEATER DT-1270', null, '<p>For selling in winter season<br />during the cold season made from Mythical Yak fur found in sheep</p>', '1', null, '2.00', 'PC', 'f', 't', 't', 'instock', null, '[]', '1', null, '2020-06-17 06:54:49', '2020-07-05 16:39:55', '1', '14fea97448f2d326be1cbf8fc71f1721');
INSERT INTO "public"."products" VALUES ('60', 'M100689', '116.56', '116.56000', 'MONTE CARLO MENS HALF SWEATER DT-2100', null, '<p>For Cold winter mornings Night wear sold seperately. No other colors available on the stocka and limited stock are provided for short duration after which the sweaters stop being warm.</p>', '1', null, '2.00', 'PC', 'f', 'f', 't', 'instock', null, '[]', '1', null, '2020-06-17 06:57:00', '2020-07-05 16:39:55', '1', '9a1c039733382f732623b11d17675d73');
INSERT INTO "public"."products" VALUES ('61', 'M10099P', '723.88', '723.88000', 'PRAE LADY HALF T-SHIRT ST-645', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f0e35c.jpg', '["M10099P_1.webp"]', '1', null, '2020-06-17 06:58:25', '2020-07-05 16:39:55', '1', '3d6a662e680ebd33b500473b117ebc65');
INSERT INTO "public"."products" VALUES ('62', 'M101089', '139.1', '139.10000', 'PLUMERIA LADY SHAWL BS-225', 'chinese shawl', '<p>Primadonna Shawl made in tibet</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f17073.jpg', '[]', '1', null, '2020-06-17 06:59:28', '2020-07-05 16:39:55', '1', '979b96985d595611485dda402d0b1416');
INSERT INTO "public"."products" VALUES ('63', 'M101091', '139.3', '139.30000', 'PLUMERIA LADY SHAWL BS-160', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f254eb.jpg', '[]', '1', null, '2020-06-17 07:00:21', '2020-07-05 16:39:55', '1', '5939d7077997c61f527e0f763f8d3a08');
INSERT INTO "public"."products" VALUES ('64', 'M10021', '105.81', '105.81000', 'RAJESH MENS SERWANI JN-1460', null, '<p>Sherwani from India</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f3295f.jpg', '[]', '1', null, '2020-06-17 07:01:37', '2020-07-05 16:39:55', '1', '3c8031d2debe23566e6b00aa742f0fca');
INSERT INTO "public"."products" VALUES ('65', 'M10032', '53.59', '53.59000', 'READY MADE SUIT PIECE -2175', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f4505d.jpg', '[]', '1', null, '2020-06-17 07:02:40', '2020-07-05 16:39:55', '1', '391ebaff517b0831496458154ab4134d');
INSERT INTO "public"."products" VALUES ('66', 'M10077', '95.134', '95.13400', 'REVLON COLORSTAY BLEMISH CONCEALER 6.2ML (IC-525)', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', null, '[]', '1', null, '2020-06-17 07:03:32', '2020-07-05 16:39:55', '1', '273711223dbe49f0ef6476c90129ef51');
INSERT INTO "public"."products" VALUES ('67', 'M100413', '120.109', '120.10900', 'SHENG QI LADY GLOVES CS-140', 'lady GLoves', '<p>Gloves for non men</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f543dc.jpg', '[]', '1', null, '2020-06-17 07:04:09', '2020-07-05 16:39:55', '1', 'bb70fce82307abf60b702207ebe432c9');
INSERT INTO "public"."products" VALUES ('68', 'M100420', '120.113', '120.11300', 'SCHOOL LIFE MINI BABY SOCKS CS-50', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f5ccde.jpg', '[]', '1', null, '2020-06-17 07:05:02', '2020-07-05 16:39:55', '1', 'aa6f64118ba7fad70f1a58f6caf49e5c');
INSERT INTO "public"."products" VALUES ('69', 'M100423', '120.116', '120.11600', 'SHENG QI LADY GLOVES CS-150', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f64755.jpg', '[]', '1', null, '2020-06-17 07:05:37', '2020-07-05 16:39:55', '1', 'dd17d976f0a508fda734a028fbff5812');
INSERT INTO "public"."products" VALUES ('70', 'M100151P', '749.178', '749.17800', 'SATACHI CARPET 67*120CM ME-929', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f73237.jpg', '[]', '1', null, '2020-06-17 07:06:00', '2020-07-05 16:39:55', '1', '3ed96b9211e9632411b7070c54bc78fc');
INSERT INTO "public"."products" VALUES ('71', 'M100426', '120.118', '120.11800', 'SHOUGUAN MENS WOOLEN CAP CS-100', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f84004.jpg', '[]', '1', null, '2020-06-17 07:07:01', '2020-07-05 16:39:55', '1', 'a2138f67c7c519a8cfcaac5aacb43d5d');
INSERT INTO "public"."products" VALUES ('72', 'M100157P', '749.182', '749.18200', 'TOPAZ CARPET 67*120CM ME-1903', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17f9010a.jpg', '[]', '1', null, '2020-06-17 07:07:58', '2020-07-05 16:39:55', '1', 'f3610034810e03352b95850d926ccc83');
INSERT INTO "public"."products" VALUES ('73', 'M100160P', '749.183', '749.18300', 'TOPAZ CARPET 100*150CM ME-3628', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', null, '[]', '1', null, '2020-06-17 07:09:21', '2020-07-05 16:39:55', '1', '3ad47f5a0f5c8c63fd362af048dcddf5');
INSERT INTO "public"."products" VALUES ('74', 'M100161P', '749.184', '749.18400', 'TOPAZ CARPET 133*190CM ME-5973', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', null, '[]', '1', null, '2020-06-17 07:10:49', '2020-07-05 16:39:55', '1', '8c0c7b0d2f3cdc418c042c8ec2b0fb5c');
INSERT INTO "public"."products" VALUES ('75', 'M100162P', '749.185', '749.18500', 'TOPAZ CARPET 160*235CM ME-9071', null, '<p>Topaz carpet</p>', '1', null, '2.00', 'PC', 'f', 'f', 't', 'instock', '5f01b17f9ec9d.jpg', '[]', '1', null, '2020-06-17 07:11:28', '2020-07-05 16:39:55', '1', '831b63c9e82f37612fca1078621a40fe');
INSERT INTO "public"."products" VALUES ('76', 'M100165P', '749.186', '749.18600', 'TOPAZ CARPET 200*285CM ME-13717', null, '<p>Topaz Carpet</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', null, '["M100165P_1.webp","M100165P_2.jpg"]', '1', null, '2020-06-17 07:12:35', '2020-07-05 16:39:55', '1', 'b0cbe91187583272c5a5391514e05cc4');
INSERT INTO "public"."products" VALUES ('77', 'M100415', '120.110', '120.11000', 'TOBU LADY SOCKS CS-60', null, '<p>lady</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17fa6dfc.jpg', '[]', '1', null, '2020-06-17 07:13:00', '2020-07-05 16:39:55', '1', '3767d5bf485c12a89d72e7d2a8ed994c');
INSERT INTO "public"."products" VALUES ('78', 'M100418', '120.112', '120.11200', 'TOBU LADY SOCKS CS-50', null, null, '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17fb232d.jpg', '[]', '1', null, '2020-06-17 07:14:22', '2020-07-05 16:39:55', '1', '29d31abcdca7015bcadcd6e488ad1e0a');
INSERT INTO "public"."products" VALUES ('79', 'M100422', '120.115', '120.11500', 'X LADY GLOVES CS-150', 'xgloves', '<p>Gloves for gifting your X</p>', '1', null, '2.00', 'PC', 'f', 'f', 'f', 'instock', '5f01b17fbe509.jpg', '[]', '1', null, '2020-06-17 07:15:19', '2020-07-05 16:39:55', '1', 'fb852fbb5b7504fb0bf58de49040b3d2');

-- ----------------------------
-- Table structure for sizes
-- ----------------------------
DROP TABLE IF EXISTS "public"."sizes";
CREATE TABLE "public"."sizes" (
"size_code" int4 DEFAULT nextval('sizes_size_code_seq'::regclass) NOT NULL,
"size_name" varchar(50) COLLATE "default" NOT NULL,
"created_by" int4,
"updated_by" int4,
"created_at" timestamp(0),
"updated_at" timestamp(0)
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of sizes
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
"id" int8 DEFAULT nextval('users_id_seq'::regclass) NOT NULL,
"member_id" varchar(255) COLLATE "default",
"email" varchar(255) COLLATE "default" NOT NULL,
"email_verified_at" timestamp(0),
"password" varchar(255) COLLATE "default" NOT NULL,
"remember_token" varchar(100) COLLATE "default",
"created_at" timestamp(0),
"updated_at" timestamp(0),
"user_type" int2,
"status" int2,
"mobile" varchar(255) COLLATE "default",
"verify_otp" bool,
"first_name" varchar(255) COLLATE "default",
"last_name" varchar(255) COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "public"."users" VALUES ('1', 'M147', 'freelancersaroj@gmail.com', null, '$2y$10$sZqqmxBo/.ggz59p1tNiHuotWLlbw79FQ79KeZ0BVKtc3vKmWVfS2', null, '2020-05-26 10:41:32', '2020-07-09 18:03:35', '2', '1', '9863352274', 't', 'Customer', 'Shrestha');
INSERT INTO "public"."users" VALUES ('2', null, 'sssarojjj@gmail.com', null, '$2y$10$yX1CJMEY0omalei8ri9OgeCSaf6Be7vkNu.i7pNMA6AmGlkvsAZnK', null, '2020-05-27 07:55:58', '2020-05-27 07:55:58', '2', '1', '9841572098', 'f', 'Saroj', 'Shrestha');
INSERT INTO "public"."users" VALUES ('3', null, 'suraj@biztechnepal.com', null, '$2y$10$toyIiU53p1EeWl3mVCfxIOJWh5zeapQhat6iUadZb78JjBU/ZjkeW', null, '2020-05-29 10:22:43', '2020-05-29 10:22:43', '1', '1', null, 'f', null, null);
INSERT INTO "public"."users" VALUES ('4', null, 'admin@admin.com', null, '$2y$10$BrMVTZ3DgGmwGPxy2yEpWut5cmEbrz.s5QwW20l3ik4Eq/fxiOLp2', null, '2020-07-02 17:43:17', null, '1', '1', null, 'f', 'Admin', 'instaror');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------
ALTER SEQUENCE "public"."barcodes_barcode_id_seq" OWNED BY "barcodes"."barcode_id";
ALTER SEQUENCE "public"."categories_category_id_seq" OWNED BY "categories"."category_id";
ALTER SEQUENCE "public"."colors_color_id_seq" OWNED BY "colors"."color_id";
ALTER SEQUENCE "public"."migrations_id_seq" OWNED BY "migrations"."id";
ALTER SEQUENCE "public"."oauth_clients_id_seq" OWNED BY "oauth_clients"."id";
ALTER SEQUENCE "public"."oauth_personal_access_clients_id_seq" OWNED BY "oauth_personal_access_clients"."id";
ALTER SEQUENCE "public"."products_pdt_id_seq" OWNED BY "products"."pdt_id";
ALTER SEQUENCE "public"."sizes_size_code_seq" OWNED BY "sizes"."size_code";
ALTER SEQUENCE "public"."users_id_seq" OWNED BY "users"."id";

-- ----------------------------
-- Primary Key structure for table barcodes
-- ----------------------------
ALTER TABLE "public"."barcodes" ADD PRIMARY KEY ("barcode_id");

-- ----------------------------
-- Primary Key structure for table categories
-- ----------------------------
ALTER TABLE "public"."categories" ADD PRIMARY KEY ("category_id");

-- ----------------------------
-- Primary Key structure for table colors
-- ----------------------------
ALTER TABLE "public"."colors" ADD PRIMARY KEY ("color_id");

-- ----------------------------
-- Primary Key structure for table migrations
-- ----------------------------
ALTER TABLE "public"."migrations" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table oauth_access_tokens
-- ----------------------------
CREATE INDEX "oauth_access_tokens_user_id_index" ON "public"."oauth_access_tokens" USING btree ("user_id");

-- ----------------------------
-- Primary Key structure for table oauth_access_tokens
-- ----------------------------
ALTER TABLE "public"."oauth_access_tokens" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table oauth_auth_codes
-- ----------------------------
ALTER TABLE "public"."oauth_auth_codes" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table oauth_clients
-- ----------------------------
CREATE INDEX "oauth_clients_user_id_index" ON "public"."oauth_clients" USING btree ("user_id");

-- ----------------------------
-- Primary Key structure for table oauth_clients
-- ----------------------------
ALTER TABLE "public"."oauth_clients" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table oauth_personal_access_clients
-- ----------------------------
CREATE INDEX "oauth_personal_access_clients_client_id_index" ON "public"."oauth_personal_access_clients" USING btree ("client_id");

-- ----------------------------
-- Primary Key structure for table oauth_personal_access_clients
-- ----------------------------
ALTER TABLE "public"."oauth_personal_access_clients" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table oauth_refresh_tokens
-- ----------------------------
CREATE INDEX "oauth_refresh_tokens_access_token_id_index" ON "public"."oauth_refresh_tokens" USING btree ("access_token_id");

-- ----------------------------
-- Primary Key structure for table oauth_refresh_tokens
-- ----------------------------
ALTER TABLE "public"."oauth_refresh_tokens" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table password_resets
-- ----------------------------
CREATE INDEX "password_resets_email_index" ON "public"."password_resets" USING btree ("email");

-- ----------------------------
-- Checks structure for table products
-- ----------------------------
ALTER TABLE "public"."products" ADD CHECK (((product_status)::text = ANY ((ARRAY['instock'::character varying, 'outstock'::character varying])::text[])));

-- ----------------------------
-- Primary Key structure for table products
-- ----------------------------
ALTER TABLE "public"."products" ADD PRIMARY KEY ("pdt_id");

-- ----------------------------
-- Primary Key structure for table sizes
-- ----------------------------
ALTER TABLE "public"."sizes" ADD PRIMARY KEY ("size_code");

-- ----------------------------
-- Uniques structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD UNIQUE ("email");
ALTER TABLE "public"."users" ADD UNIQUE ("mobile");

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD PRIMARY KEY ("id");
