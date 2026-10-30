-- Adminer 5.4.0 PostgreSQL 18.6 dump

DROP TABLE IF EXISTS "events";
DROP SEQUENCE IF EXISTS events_id_seq;
CREATE SEQUENCE events_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."events" (
    "id" integer DEFAULT nextval('events_id_seq') NOT NULL,
    "title" character varying(100) NOT NULL,
    "description" text,
    "event_date" timestamp,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT "events_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);


DROP TABLE IF EXISTS "registrations";
DROP SEQUENCE IF EXISTS registrations_id_seq;
CREATE SEQUENCE registrations_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."registrations" (
    "id" integer DEFAULT nextval('registrations_id_seq') NOT NULL,
    "event_id" integer NOT NULL,
    "name" character varying(50) NOT NULL,
    "phone" character varying(30) NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT "registrations_pkey" PRIMARY KEY ("id")
)
WITH (oids = false);


ALTER TABLE ONLY "public"."registrations" ADD CONSTRAINT "registrations_event_id_fkey" FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE NOT DEFERRABLE;

-- 2026-10-30 07:11:04 UTC
