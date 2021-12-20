--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.19
-- Dumped by pg_dump version 9.6.17

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: categorie; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.categorie (nomcategorie) FROM stdin;
scientifique
sportif
musical
jeu
soirée
marathon
théâtre
rock
festival
Musique
cinema
\.


--
-- Data for Name: evenement; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.evenement (numevenement, titre, description, debutage, limiteage, lieu, datedebut, datefin) FROM stdin;
3	Exposition du Théatre 	Une exposition du théâtre aura lieu dans le centre de la ville, y aura tous ce que voulez	7	\N	20 Rue Chevalret, 75006 Paris	2022-01-29	2022-03-10
4	Festival de La Ville	Le festival de la ville est très proche, beaucoup de célébrités arriveront. Venez!!	6	\N	20 Rue Chevalret, 75006 Marseille	2022-01-15	2022-01-20
5	Compétition de musculation	Vous attendez quoi? Participez à cette compétition de musculation pour gagner un abonnement gratuit	14	\N	20 Rue Chevalret, 75006 Marseille	2021-01-15	2021-01-20
1	Marathon de La ville	La ville va organiser un marathon de course, le gagnant aura une grande surprise! Venez nombreux	10	40	215 Marechal Foch, 46936 Nation	2021-07-10	2021-07-11
2	Concert Rock	Y aura un grand concert de Rock prochainement. Ne ratez pas cet événement fabuleux	18	60	215 Marechal Foch, 46936 Marseille	2022-01-05	2022-01-09
6	La soirée de bonne année	La soirée du bonne année est là. Venez nombreux!!	20	50	20 Rue Chevalret, 75006 Lyon	2022-12-24	2022-12-28
7	Exposition des jeux vidéo	La plus grande exposition des jeux vidéos où y aura tous les types!	7	18	20 Rue Chevalret, 75006 Grenoble	2021-01-02	2021-01-05
8	Compétition du gymnastique	La plus grande compétition de gymnastique de la france	15	40	21 Rue Nationale, Paris	2022-02-05	2022-02-06
9	Evenement de musique	Cette evenement se deroulera à 13 val de roissy, 92372 Val d'oise, il est accessible pour les gens entre 15 et 70 ans, venez nombreux s'ils vous plait, il y aura la nourriture et la musique.\n	15	70	13 val de roissy, 92372 Val d'oise	2022-12-12	2022-12-15
10	Gaming For Life	Venez jouer et passez des bons moments	14	85	84 Rue de Revolut, Paris	2022-02-12	2022-03-14
11	Fête de Noel	Ne ratez pas cette fête fabuleuse!	18	60	21 Rue Barbès Ivry sur Seine	2022-04-01	2022-05-01
12	Film au cinema de Marseille	Dans le cinema de Marseille à 12 kasperg, 98392 Marseille il y aura un film qui s'appel "l'avenir des prof"	10	20	12 kasperg, 98392 Marseille	2021-01-01	2021-01-05
\.


--
-- Data for Name: appartient; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.appartient (numevenement, nomcategorie) FROM stdin;
1	marathon
2	rock
3	théâtre
4	festival
5	sportif
6	soirée
7	jeu
8	sportif
9	Musique
10	jeu
11	festival
12	cinema
\.


--
-- Data for Name: datee; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.datee (dateinscription) FROM stdin;
2021-07-10
2021-01-16
2021-01-17
2021-01-18
2021-01-15
2021-01-20
2021-01-19
2020-12-24
2020-12-25
2020-12-26
2020-12-27
2022-02-02
2022-01-16
2022-01-08
2022-02-20
2022-02-15
2022-01-18
2022-12-25
2021-01-04
2022-02-05
2022-01-29
2022-01-06
2022-01-15
2022-12-12
2022-04-30
2022-01-01
2021-01-01
\.


--
-- Name: evenement_numevenement_seq; Type: SEQUENCE SET; Schema: public; Owner: yassine.el-jide
--

SELECT pg_catalog.setval('public.evenement_numevenement_seq', 12, true);


--
-- Data for Name: utilisateur; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.utilisateur (login, prenom, motdepasse, adresse, datenaissance) FROM stdin;
Durand.b	Durand	KlaykDurand@1981	Klayk.Durand17@outlook.com	1981-05-17
Bret.e	Robert	BretRobert@1995	Bret.Robert19@gmail.com	1995-06-19
Ferguson.e	Alfred	Ferguson@1984	Ferguson.Steph20@outlook.com	1984-02-20
Badr.Steph	Steph	Steph@1923	Steph.badr@gmail.com	2003-01-30
Hari.o	Dubois	HariDubois@1997	Hari.Dubois12@outlook.com	1997-02-12
Steven12	steven	steven	steven@gmail.com	2002-11-28
Yassine12	yassine	yassine	yassine@gmail.com	1999-01-04
Lucas12	lucas	lucas	lucas@outlook.com	1990-02-12
Marie12	marie	marie	marie12@outlook.com	1994-03-13
Maxime12	maxime	maxime	maxime@outlook.com	2004-03-13
Anass12	Anass	anass	anasousaid2@gmail.com	2003-04-26
\.


--
-- Data for Name: inscrit; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.inscrit (numevenement, login, dateinscription, commentaire, avis) FROM stdin;
5	Bret.e	2021-01-17	Bonne expérience	4
1	Bret.e	2021-07-10	Superbe!	5
1	Steven12	2021-07-10	Très mal expérience	2
5	Maxime12	2021-01-18	Très compétitif!	5
3	Yassine12	2022-02-02	\N	\N
4	Yassine12	2022-01-16	\N	\N
2	Yassine12	2022-01-08	\N	\N
3	Maxime12	2022-02-20	\N	\N
3	Lucas12	2022-02-15	\N	\N
2	Lucas12	2022-01-08	\N	\N
4	Yassine12	2022-01-18	\N	\N
6	Yassine12	2022-12-25	\N	\N
7	Yassine12	2021-01-04	Bien	4
8	Yassine12	2022-02-05	\N	\N
3	Steven12	2022-01-29	\N	\N
8	Anass12	2022-02-05	\N	\N
2	Steven12	2022-01-06	\N	\N
4	Anass12	2022-01-15	\N	\N
5	Yassine12	2021-01-16	Très compétitif	5
9	Anass12	2022-12-12	\N	\N
10	Yassine12	2022-02-20	\N	\N
1	Anass12	2021-07-10	Marathon au top	4
11	Steven12	2022-04-30	\N	\N
12	Anass12	2021-01-01	pas mal	4
\.


--
-- Data for Name: invitation; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.invitation (idinvitation, message, statut, loginexpediteur, logindestinataire, dateinscription, numevenement) FROM stdin;
1	Rejoins Moi!	En Cours	Yassine12	Badr.Steph	2022-01-08	2
2	Rejoins Moi!	En Cours	Yassine12	Ferguson.e	2022-01-08	2
3	Rejoins Moi!	Accepté	Yassine12	Marie12	2022-01-08	2
6	Hésite pas à venir, si tu veux!	En Cours	Maxime12	Ferguson.e	2022-02-20	3
5	Rejoins Moi!	Accepté	Yassine12	Maxime12	2022-01-08	2
7	Tu penses venir la prochaine fois ? \r\n	En Cours	Maxime12	Durand.b	2022-02-20	3
4	Rejoins Moi!	Accepté	Yassine12	Lucas12	2022-01-08	2
9	Tu viens ? 	En Cours	Lucas12	Hari.o	2022-01-08	2
10	On passera des bons moments\r\n	En Cours	Lucas12	Maxime12	2022-01-08	2
8	Vsy Steven, ta dernière chance!	Accepté	Maxime12	Yassine12	2022-02-20	3
11	Hésite pas à venir\r\n	En Cours	Yassine12	Badr.Steph	2022-12-25	6
12	Il est très bien cet événement!	En Cours	Yassine12	Maxime12	2022-12-25	6
13	Vasy On part ensemble	En Cours	Yassine12	Hari.o	2022-12-25	6
14	Viens avec moi stp	Accepté	Steven12	Yassine12	2022-01-29	3
15	En se voit la bas ?\r\n	Accepté	Anass12	Steven12	2022-02-05	8
16	Tu viens ou pas ? \r\n	Refusé	Steven12	Anass12	2022-01-06	2
18	Viens Joue avec moi stp! :)	En Cours	Yassine12	Anass12	2022-02-20	10
17	en part?	Refusé	Anass12	Yassine12	2022-01-15	4
20	Rejoins Nous !!	En Cours	Steven12	Anass12	2022-04-30	11
\.


--
-- Name: invitation_idinvitation_seq; Type: SEQUENCE SET; Schema: public; Owner: yassine.el-jide
--

SELECT pg_catalog.setval('public.invitation_idinvitation_seq', 20, true);


--
-- Data for Name: lienparente; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.lienparente (utilisateur1, utilisateur2, lien) FROM stdin;
Ferguson.e	Badr.Steph	pére
Bret.e	Hari.o	frére
\.


--
-- Data for Name: photo; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.photo (idphoto, lienphoto, numevenement, login) FROM stdin;
26	uploads/61bfad1cd69001.48125165.jpg	5	Yassine12
27	uploads/61bfad475434c5.62941606.jpg	7	Yassine12
28	uploads/61bfaea32ea0f1.30556200.jpg	1	Steven12
29	uploads/61bfaffd4d4786.66901837.jpeg	1	Anass12
30	uploads/61bfb361cc6f47.24994594.jpeg	12	Anass12
\.


--
-- Name: photo_idphoto_seq; Type: SEQUENCE SET; Schema: public; Owner: yassine.el-jide
--

SELECT pg_catalog.setval('public.photo_idphoto_seq', 30, true);


--
-- Data for Name: tag; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.tag (idtag, nomtag) FROM stdin;
1	#SportForEveryOne
2	#ScienceForEveryOne
3	#Jeux
4	#Rap
5	#LoveArt
6	#Nighttime
7	#MusicForEveryone
8	#football
9	#soccer
10	#Art
11	#matchdefoot
12	#festival
13	#festivalautop
14	#festivaldemarseille
15	#marseille
16	#musique
17	#rap
18	#vald'oise
19	#gymnastique
20	#paris
21	#gymnastiqueDeParis
22	#evenement
23	#photo
\.


--
-- Name: tag_idtag_seq; Type: SEQUENCE SET; Schema: public; Owner: yassine.el-jide
--

SELECT pg_catalog.setval('public.tag_idtag_seq', 23, true);


--
-- Data for Name: tagger; Type: TABLE DATA; Schema: public; Owner: yassine.el-jide
--

COPY public.tagger (numevenement, idtag, login) FROM stdin;
2	2	Yassine12
3	2	Ferguson.e
7	8	Anass12
7	9	Anass12
3	10	Yassine12
7	11	Anass12
4	12	Anass12
4	13	Anass12
4	14	Anass12
4	15	Anass12
9	16	Anass12
9	17	Anass12
9	18	Anass12
8	19	Anass12
8	20	Anass12
8	21	Anass12
5	22	Anass12
5	23	Anass12
1	23	Anass12
1	22	Anass12
3	23	Anass12
12	23	Anass12
2	23	Anass12
4	23	Anass12
\.


--
-- PostgreSQL database dump complete
--

