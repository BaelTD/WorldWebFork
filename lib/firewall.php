<?php
if (!defined('BLARG')) die();

function do403() {
	header('HTTP/1.1 403 Forbidden');
	header('Status: 403 Forbidden');
	die('403 Forbidden');
}

function do404() {
	header("HTTP/1.0 404 Not Found");
	header('HTTP/1.1 404 Not Found');
	header("HTTP/2.0 404 Not Found");
	header('Status: 404 Not Found');
	die('404 Not Found');
}

// weird bots. Rumors say it's hacking bots, or the bots China uses to crawl the internet and censor it
// in either case we don't lose much by keeping them out
if ($_SERVER['HTTP_USER_AGENT'] == 'Mozilla/4.0')
	do403();

// spamdexing in referrals/useragents
if (isset($_SERVER['HTTP_REFERER'])) {
	if (stristr($_SERVER['HTTP_REFERER'], '<a href=') ||
		stristr($_SERVER['HTTP_USER_AGENT'], '<a href='))
		do403();
}

// spamrefreshing
if (isset($_SERVER['HTTP_REFERER'])) {
	if (stristr($_SERVER['HTTP_REFERER'], 'refreshthis.com'))
		do403();
}

if ($isBot) {
	// keep SE bots out of certain pages that don't interest them anyway
	// TODO move that code to those individual pages
	$forbidden = ['register', 'login', 'online', 'referrals', 'records', 'lastknownbrowsers'];
	if (in_array($http->get('page'), $forbidden))
		do403();
}

//Email Domains to block
$emaildomainsblock = [
'@07t15ru-fb2wo7r-szlcx1.com',
'@0815.ru',
'@0euros.fr',
'@0jortzl-0pl.com',
'@0quue7l-j3a.com',
'@0xyu9jp-blh.com',
'@10minutemail.co.za',
'@10minutemail.com',
'@1dmvlbx-tpo.com',
'@1qidt8b-gre.com',
'@1y9w5cg-eja.com',
'@2439o7t-xnm.com',
'@24a0cgd-dar.com',
'@24lovenight.com',
'@292vmtb-tyb.com',
'@2glr9by-bri.com',
'@2qy-tw-ap8.biz',
'@2rqbhn7-oaz.com',
'@33mail.com',
'@3gdlndw-mas.com',
'@3pwq0a6-nqk.com',
'@3t349i6-cuy.com',
'@3v3sfol-80b.com',
'@3vj1i1d-1tm.com',
'@474hd53-vrt.com',
'@5939sutter.com',
'@5ere41j-pxv.com',
'@5ktl05m-wyy.com',
'@5l059yg-tjw.com',
'@5umarej-sgd.com',
'@5ws6u8j-vfd.com',
'@61wflgi-r9x.com',
'@6hij1oh-7tc.com',
'@6ip.us',
'@6t5f74w-xvn.com',
'@6vjssbf-usd.com',
'@6z5rcrz-qet.com',
'@72czhtx.com',
'@74sedwg-bxz.com',
'@777-a-bingo.us',
'@79obmbh-xhu.com',
'@7eas4l8-jos.com',
'@7fb0er3-tni.com',
'@7g2z8dg-ewk.com',
'@7kn4vw6-ike.com',
'@7lk820m-gtc.com',
'@8568bakerave.com',
'@87yp5e7-vvb.com',
'@8lbxceq-uco.com',
'@8q8qw8u-hnp.com',
'@8z7gv4g-fbu.com',
'@90kezzu-kla.com',
'@99l0jzn-klx.com',
'@9gj65y1-jai.com',
'@9se1bx4-8ui.com',
'@a1tw3jh-gbw.com',
'@a5rz44y-j54.com',
'@acellpharmacy.com',
'@achristmascoupon.com',
'@acis-ru.ru',
'@adanadahersey.info',
'@advicestrict.pw',
'@ae58cwg-yxq.com',
'@agentslimmer.com',
'@aiochristmas.com',
'@alertmedicalnews.com',
'@allnowcannabis.com',
'@amazingcraft.co',
'@amazingphotshd.com',
'@ana-bnayti.com',
'@anarimaconbanana.com',
'@animalatheart.com',
'@annpluslauren.us',
'@anpsbassano.com',
'@aplle.biz',
'@apodeictic.us',
'@appldingjkd.info',
'@appsid-manage.com',
'@aqfw1r6-fxw.com',
'@armyspy.com',
'@aseosearch.org',
'@asijdrco.ru',
'@asistanliksemineri.info',
'@assetmanagingfast.com',
'@asuji.com',
'@athascapital-jeffkrecioch.net',
'@atikcookies.co.id',
'@attactury.com',
'@attention14.fr',
'@auto-and-news.ru',
'@autoorangefresh.com',
'@azshopps.com',
'@bacpost.in',
'@bakad.us',
'@bartfeon.com',
'@basions.com',
'@bavaj.us',
'@bb5kmbs-aib.com',
'@bcenw5t-za0.com',
'@bdz6pqk-snw.com',
'@beacomediantips.com',
'@beckaluelle.ru',
'@beckicoreen.com',
'@bedhealthplus.us',
'@befitjersey.com',
'@believeonholidays.com',
'@bestcomplexionever.com',
'@bestedmedrxshop.com',
'@bestnewrewardspecials.com',
'@bestwebp.su',
'@bestwebstore.su',
'@betration.info',
'@betterhdtools.com',
'@betterspotone.com',
'@beverlyplusdiane.us',
'@biddingnewrewardspecials.com',
'@bigsteaktaste.com',
'@bijougrandcru.com',
'@bilongo.info',
'@bingo-a-bet.us',
'@bingo-a-vegas.us',
'@binkmail.com',
'@biripincaalpacas.com',
'@bj5rv53-q36.com',
'@blackandwhitecookie.pw',
'@blh3do5-ahw.com',
'@bobmail.info',
'@boilfrank.com',
'@bomnegocioweb.com.br',
'@boosjinksan.info',
'@bootsend.info',
'@bosac.us',
'@botetik.ru',
'@boujhfytun.info',
'@boun.cr',
'@bqwkkxac.ru',
'@brennendesreich.de',
'@brillant45.fr',
'@broadwaybowlmo.com',
'@brookbeverly.in',
'@buildthedeals.info',
'@buldogshots.com',
'@bullshotdevice.com',
'@bund.us',
'@buretyine.us',
'@businessknowledgetoday.com',
'@bzfyazabi.com',
'@bzt-phosphate.com',
'@c55waxf-7vy.com',
'@cachedot.net',
'@camboriu.online',
'@campoyo.eu',
'@canadajazzstudio.com',
'@canadiasite24.co.com',
'@candidatelatestnewinfo.com',
'@candidatenewestonlineupdates.com',
'@candidateupdatednewinfo.com',
'@canlivewellgo.com',
'@canusa.co',
'@capitalindex.info',
'@carhibrid.us',
'@caribban.us',
'@carolyn-theresa.us',
'@cashbackbig.info',
'@cashforcarsbristol.co.uk',
'@casino-a-jackpot.us',
'@casino-a-winner.us',
'@casino-and-777.us',
'@ce.mintemail.com',
'@cehp2trngs.com',
'@certainlyhealthreport.info',
'@cgcourierservices.com',
'@chaletsdevanoise.com',
'@challenge-toushi.com',
'@chammy.info',
'@chanforsenate.com',
'@chareadeltant.com',
'@cheapjerseysdiscount.us.com',
'@cheapsportsjerseysnfl.us.com',
'@checkgreengrass.com',
'@chemistryflash.com',
'@chinaz-5886.org',
'@chirofithealing.com',
'@chydbolz.info',
'@cil24fg-pzc.com',
'@cingkisjou.info',
'@ciuiduusnosin.info',
'@claim-your-funds.com',
'@clarettehenriette.ru',
'@cleanenergynevadamail.com',
'@clicktextech.com',
'@clinicabiuti.com',
'@cliphdimage.com',
'@cloudoffer.info',
'@clrmail.com',
'@cnvjdksrih.info',
'@cokingjkdir.info',
'@colrosariolagos.com',
'@complexlooks.com',
'@confirm-your-deposit.com',
'@confirmlinkedlog.pw',
'@contato890.com.br',
'@continght.info',
'@coolinkyter.info',
'@corenaminni.ru',
'@coringkirs.info',
'@corsva.com',
'@couninghfj.info',
'@countershops.com',
'@cpmworld.org',
'@crareal.info',
'@ctsogifts.com',
'@customerservicehealth.com',
'@cuttingdefense.com',
'@cuttingedgepen.com',
'@cuvox.de',
'@cxinmiao.com',
'@cy-n2lceu.biz',
'@cybermarkt.info',
'@dacoolest.com',
'@dailydealhunts.com',
'@dalsoleenergy.com',
'@danceloan.pw',
'@danielleplussamantha.us',
'@dannyjenilee.in',
'@darotis.ru',
'@date1to.com',
'@date4time.com',
'@dateasianbeautiesnice.us',
'@daterk.com',
'@dayrep.com',
'@dealsforyounow.info',
'@dealtoblackfriday.com',
'@deannaalys.in',
'@debtreaction.pw',
'@defensesling.com',
'@defensetoolnewupdates.com',
'@degrefinance.us',
'@deniseplusmildred.us',
'@dertuihydg.info',
'@designyourvideo.info',
'@devnullmail.com',
'@diamondevel.info',
'@digitalallmemores.com',
'@dinepurer.us',
'@dinglistem.com',
'@diplocam.cm',
'@dirlija.com',
'@discard.email', '@discardmail.com', '@discardmail.de', //All discard emails
'@dispomail.eu',
'@dispostable.com',
'@diwua.us',
'@djeneriki-rf.ru',
'@dkfijffkjkgi.info',
'@dobuylist.com',
'@dodgit.com',
'@dofuw.us',
'@doifundjun.info',
'@doinfjksjd.info',
'@doingjdks.info',
'@doingjkid.info',
'@dojikorits.info',
'@dokumentarnaj-podgotovka.ru',
'@donetacticals.com',
'@dongkhind.info',
'@doozoo.us',
'@doseimpulse.pw',
'@dounightre.info',
'@drabli-pipa.com',
'@drdrb.com',
'@drole947.fr',
'@dskonline.eu',
'@ducud.us',
'@dufai.us',
'@dulceasheelagh.ru',
'@duvvip.us',
'@dxrsfacb.ru',
'@e4kdx60-5g890n0-7jd30ih.com',
'@e9rjqy4-05kaba1-f9lm3y6.com',
'@eaintrer.us',
'@eatsttopeat.us',
'@eattstopeat.us',
'@ebbu2uw-cn9q0rn-0pevnrq.com',
'@ecorrentivel.com',
'@ediblehdphotos.com',
'@edspain.com',
'@ee0zp1d-tzi.com',
'@eelmail.com',
'@efpa3pn-zds.com',
'@ehzytxgm.ru',
'@einrot.com',
'@ej3e7a6-anw.com',
'@eladred.info',
'@electronze.com',
'@elivicy.info',
'@emaarnews.info',
'@email-clouds.com',
'@emailbackend.com',
'@emailproxsy.com',
'@embracegoodshop.com',
'@emelinajenda.ru',
'@enfant-joyeux.fr',
'@epointsamaso.com',
'@erdcz9t-bfr.com',
'@etg-dfq-mi.biz',
'@faemia.com',
'@fanij.us',
'@fantasticmega.net',
'@fasteresult.us',
'@fastpillstore.ru',
'@fastremedymall.ru',
'@fatburnn.us',
'@favdum.us',
'@fcwider.info',
'@feelthishop.com',
'@feierteled.com',
'@fengshuozitan.com',
'@feriasavenidahotel.info',
'@fezot.us',
'@finalwelcome.pw',
'@fingjkdurie.info',
'@fiogkidjd.info',
'@flavortosteak.com',
'@fleckens.hu',
'@floreriasquito.com',
'@focuspurposes.com',
'@forhdkinfs.info',
'@forwardgiftings.com',
'@fozoh.us',
'@franklexi.com',
'@frondmcgurk.info',
'@fsnumerique.com',
'@fubid.us',
'@fulingkdin.info',
'@fullhardcocktail.com',
'@fullmannashoes.pro',
'@fullsadvantages.com',
'@fulltrendsbiz.com',
'@funijhyton.info',
'@funjikfnkdo.info',
'@fuscapreto.com.br',
'@g71g0ei-cel.com',
'@gadin.us',
'@gaffeapplication.pw',
'@gaffeattic.pw',
'@gaffereaction.pw',
'@gaffetemperature.pw',
'@gajjudealwala.pro',
'@gamuj.us',
'@gebod.us',
'@generator30guide.info',
'@getairmail.com',
'@getmedeal.pro',
'@giftctos.com',
'@globalinformationnetwork.net',
'@globalreportest.com',
'@gluttonoushipster.com',
'@goawur.us',
'@god-fogive.us',
'@gograbthisnow.com',
'@goinfor.us',
'@golddslimers.com',
'@goldensgroups.com',
'@goldslimers.com',
'@goodairsnews.com',
'@goodfastreward.com',
'@goodorganicstore.ru',
'@goodspharma.com',
'@gqecobartending.com',
'@grande-victoire.fr',
'@grassgoodtoday.com',
'@grasssoldiers.com',
'@gratbrainn.us',
'@gravitysoup.pro',
'@greatdeal.pro',
'@greatholidaydeals.info',
'@greatoneshots.com',
'@greenpoweremcinc.com',
'@greetwound.pw',
'@grouplegalization.com',
'@grr.la',
'@gs72a5d-bls.com',
'@guerrillamail.biz', '@guerrillamail.com', '@guerrillamail.de', '@guerrillamail.net', '@guerrillamail.org', '@guerrillamailblock.com', //All guerrillamail.
'@gukeo.us',
'@gustr.com',
'@gzjiafang.com',
'@h0gw0se-sut.com',
'@h22snid-xiw.com',
'@haajob.com',
'@hakancakan.com',
'@hannahgrayson.com',
'@hannahplusvirginia.us',
'@happy-a-jackpot.us',
'@happycouponsshop.com',
'@happyfortunetrophy.us',
'@harakirimail.com',
'@harbapress.com',
'@hausbautipp.com',
'@hbwseminer.info',
'@hbwsemineri.info',
'@hbwseminerleri.info',
'@hbylina.ru',
'@hdmazingphotos.com',
'@hdmorephotos.com',
'@hdxprophotos.com',
'@headlineprovider.com',
'@healthfact.us',
'@helenpluslauren.us',
'@helping-verify.com',
'@helpingstudents.pw',
'@hietherepert.us',
'@hiltgvokleis.info',
'@hinkytrerdfs.info',
'@hireassists.us',
'@hm-eshop.com',
'@hmiekonomiua.id',
'@holdingoffers.com',
'@holdmysling.com',
'@holidaynewestletterinfo.com',
'@holidaynewesttreespecials.com',
'@hostingfiberdeals.info',
'@ht7is62-ewx.com',
'@hulapla.de',
'@hulomix.com',
'@humoned.com',
'@hurdleguard.com',
'@hushmail.com',
'@i-messager.com',
'@iamlooner.com',
'@identitypreoccupation.pw',
'@imeldaorelee.in',
'@imgof.com',
'@imgv.de',
'@inboxproxy.com',
'@incognitomail.org',
'@incredibletac11.com',
'@indepthdphoto.com',
'@inshoptails.com',
'@instanthdphtoos.com',
'@instantmeltins.com',
'@instantsgifths.com',
'@intensedheadlamsp.com',
'@inter-sity.ru',
'@internclub.ru',
'@interurconsult1.ru',
'@invitebite.pw',
'@inviteghost.pw',
'@ioiopopo001.in',
'@isimoyunlari.com',
'@itsaboomshot.com',
'@itsmadeofsteel.com',
'@itsshopnews.com',
'@itsthegrasday.com',
'@itsthepharmacy.com',
'@jacksmail.info',
'@jacquelinepluslinda.us',
'@janeplusjulia.us',
'@japanrul.ru',
'@jenniferplusrebecca.us',
'@jiayigj.com',
'@jikev.us',
'@jikqnst-pak.com',
'@jilleenagata.ru',
'@jinhtgfrtt.info',
'@jinlinger.us',
'@jiuyoufood.com',
'@jodypickett.com',
'@johndalymusician.com',
'@jojomomo004.in',
'@jojororo002.in',
'@jose-garciaabogados.es',
'@jourrapide.com',
'@jpitlf5-imf.com',
'@jr8mvp2-7ye.com',
'@jswjyb.com',
'@judgeen.us',
'@judynurseart.com',
'@juxn9bm-iup.com',
'@k0fuc7x-trv.com',
'@kehiz.us',
'@keizudo.com',
'@kellbluecbooks.com',
'@kellinaelsey.in',
'@kennetheasby.net',
'@kerriepriscilla.ru',
'@kielejoanne.in',
'@kkeegan.com',
'@klischdroid.info',
'@knifethruhead.com',
'@kokojojo002.in',
'@kowot.us',
'@krytex-pro.ru',
'@kurue.us',
'@kylenfayre.com',
'@l6z01lm-mqf.com',
'@la-nouvelle-information.fr',
'@lags.us',
'@lamplatestspecialupdates.com',
'@landercots.com',
'@landergifts.com',
'@landingshopss.com',
'@landinshop.com',
'@lanif.us',
'@laptops-store.ru',
'@latestrewardonlinespecials.com',
'@lawrant.com',
'@layermax.info',
'@layerquality.info',
'@learntoincreasenow.com',
'@ledealanepasrater.fr',
'@lednewestlightspecials.com',
'@legalizeits.com',
'@letthemeatspam.com',
'@lg93l97-ah9smht-pen20t.com',
'@li1dvff-fxz.com',
'@libertynewstoday.co',
'@lifesgreatworks.com',
'@lifeskating.com',
'@lightlednewestspecials.com',
'@lightonlinenewestled.com',
'@lightonlinenewestspecials.com',
'@lightspecialnewestledinfo.com',
'@lightspecialsnewled.com',
'@likeloves.com',
'@liquifydesign.com',
'@liroh.us',
'@literaryloancredit.info',
'@livinginhopetoun.com',
'@livue.us',
'@llacrie.info',
'@lm4hz94-93s.com',
'@loan-help-asap.pw',
'@lonetreerentals.com',
'@lotonacional.com',
'@lottospromos.com',
'@lowerlf.us',
'@lucky-bums-com.ru',
'@m9ygryj-c1j.com',
'@magcamhd.com',
'@magnashops.com',
'@magnumshapes.com',
'@maildrop.cc',
'@mailforspam.com',
'@mailhub.pw',
'@mailimate.com',
'@mailinator.com', '@mailinator.net', '@mailinator2.com', //All mailinator.
'@mailnesia.com',
'@mailnull.com',
'@mailproxsy.com',
'@mailtothis.com',
'@mainnewsever.com',
'@mainpen.com',
'@majormastersof.com',
'@majortacpens.com',
'@majortacticals.com',
'@maputa.info',
'@marenkarehilde.in',
'@markperreault.com',
'@markstephensons.co.com',
'@marryen.us',
'@maxcp2m-gy9hzax-3xuc6h.com',
'@maxibiztrends.com',
'@maxshotprime.com',
'@maxsimusdvantage.com',
'@mcorefts.org',
'@meadleerubber.com',
'@mealspecialnewestrewards.com',
'@meanliec.info',
'@medigapp.us',
'@melisameltings.com',
'@melittaalthea.in',
'@melterspills.com',
'@meltinghtsl.com',
'@meltingnow.com',
'@meltingsuperponds.com',
'@meltmail.com',
'@membernewestspecials.com',
'@memberrewardnewinfo.com',
'@memorizevitals.com',
'@merapaisa.pro',
'@merilynjanelle.in',
'@metlallpoundsoff.com',
'@mfug9wz-z7e.com',
'@mfvbynr-yre.com',
'@microavto1.ru',
'@mikesmail.info',
'@milim.us',
'@mindamazingness.com',
'@mintemail.com',
'@miracle16.fr',
'@misteroilliver.com',
'@mivih.us',
'@mkecomunica.com',
'@mlzajsf-5tt.com',
'@modsmx.com',
'@moket.us',
'@mon-plan-secret.fr',
'@money-a-win.us',
'@moreencomes.com',
'@moreofferplease.com',
'@morgaggpln.us',
'@morincomenow.com',
'@mostimcome.com',
'@mostlymanaging.com',
'@mostmac.com',
'@motaotj.com',
'@muchhdphotos.com',
'@my10minutemail.com',
'@mybobkerfaz8online.com',
'@mychristmass.com',
'@myglobalsale.ru',
'@myhealthassist.ru',
'@mynetstore.de',
'@myonlypage.com',
'@myraolimpia.ru',
'@myreikicoach.com',
'@mysuperblend.com',
'@mytrashmail.com',
'@nccnewss.com',
'@needmoredevices.com',
'@neliv.us',
'@nest-marketi-ru.ru',
'@net-kurevu.ru',
'@never360.com',
'@nevev.us',
'@newbidbonusspecials.com',
'@newbigdlie.info',
'@newbonusonlineupdates.com',
'@newbrainstimulator.us',
'@newcookbook.us',
'@newearningonlineupdates.com',
'@newestholidayletters.com',
'@newfashions.info',
'@newfinalbubble.us',
'@newlayer.info',
'@newlyshopping.com',
'@newpennyoptioninfo.com',
'@newpenonlinespecials.com',
'@newpowertech.us',
'@newsyshops.com',
'@newwoodwork.us',
'@nieltrest.us',
'@niko-matkoum.com',
'@nimil.us',
'@nomia.us',
'@nonspam.eu',
'@nonspammer.de',
'@nostopmelt.com',
'@notiloteriasec.com',
'@notmailinator.com',
'@notuighndin.info',
'@nowinvesting.net',
'@nul5x97-jss.com',
'@nvcleanenergymailer.com',
'@nw4uxic-kbm.com',
'@o898dcg-q3a.com',
'@o8cznr2-kkg.com',
'@offerchopper.com',
'@offflash.com',
'@offres-degriffees.fr',
'@offsecretrevealed.com',
'@oilystuffing.com',
'@oilythingsc.com',
'@oj27wlf-obz.com',
'@omgreward.com',
'@onfreeenergydevicewant.us',
'@onlinerecip.com',
'@opalinaeadith.com',
'@optnewsletters.com',
'@opulence-group.net',
'@ordermanagings.com',
'@organizator.info',
'@originalspinmop.com',
'@osciouttrice.us',
'@outnewsender.info',
'@overcashstudios.com',
'@owwaodn-7l4.com',
'@oyip531-ens.com',
'@p2trngcert.com',
'@p3f5t99-lf9.com',
'@p3pwbwm-e6n.com',
'@p4eq2cv-9z0.com',
'@pafuv.us',
'@pancoerce.pw',
'@partir-loin75.fr',
'@patdoul.eu',
'@paxsonfiller.us',
'@pcurl.com',
'@peepee003.in',
'@peersloater.us',
'@peextwothrm.com',
'@pendefendertac1.com',
'@pennewesttacticalinfo.com',
'@pentacpen.com',
'@pepah.us',
'@perchkilt.us',
'@pharmacylifes.com',
'@pickupbrands.pro',
'@plaisir-ensemble14.fr',
'@planarexpert1s.ru',
'@planossaudeonline.we.bs',
'@plusbelleencore.com',
'@pluspharmanow.com',
'@potbusinessups.com',
'@potenzpilleneinkaufen.us',
'@potenzpillenkaufen.us',
'@potsecretssfl.com',
'@potsrebelion.com',
'@potteryfinance.pw',
'@poundmelterfast.com',
'@ppl-secure-notification.com',
'@presseonvaou.com',
'@primaflaslights.com',
'@prinsan.com',
'@printissimo-ru.ru',
'@privacycare.pw',
'@professionundermine.pw',
'@profit-a-chance.us',
'@proflytgame.us',
'@prograncy.com',
'@progressyourprofession.com',
'@prohdcamss.com',
'@prohdimages.com',
'@promosmtp.co',
'@proshdimages.com',
'@prosuperiorhd.com',
'@publiverddigital.com',
'@puddingenhance.pw',
'@pumpwound.pw',
'@pumuv.us',
'@puringhjiku.info',
'@pushpays.info',
'@putuw.us',
'@px5qwuy-kx4.com',
'@q53yh1d-qpj.com',
'@qi9g5cd-u5hwwqi-li21p44.com',
'@qoika.com',
'@qoinivh-fhn.com',
'@qrdifmg-jgp.com',
'@qrg37rn-ueb.com',
'@qsa46y7-t26.com',
'@qt6c31c-6fa.com',
'@qualityinfo.info',
'@quitpromote.pw',
'@qyrjaprn.com',
'@r3xnrmo-nzi.com',
'@racegame.us',
'@ragene.ru',
'@rajuhsinfjsun.info',
'@ralphlaurenimall.com',
'@rani-mtanan.com',
'@ratural.com',
'@reactingdefense.com',
'@reallymymail.com',
'@reclimcntrol.us',
'@reconmail.com',
'@reeree001.in',
'@reeree003.in',
'@regorgasservice.org',
'@regretfrozen.pw',
'@rehabalcohl.us',
'@remindsmegrass.com',
'@rerii.us',
'@retro-times.ru',
'@reviewhddevice.com',
'@rewardoptionnewestbonus.com',
'@rewardspecialmemberinfo.com',
'@rewardupdatednewestspecials.com',
'@rezeptfreiliebe.us',
'@rezeptfreimenshealth.us',
'@rhyta.com',
'@rigolade-partagee.fr',
'@rikbui.us',
'@rimaj.us',
'@rufop.us',
'@ruingodkis.info',
'@runningnews.ru',
'@ryhuheqw.com',
'@s0ny.net',
'@s0w8lcf-obe.com',
'@s7c3yx3-apf.com',
'@sa43ffh-uxi.com',
'@safe-systems-mail.org',
'@safedate9.com',
'@safetymail.info',
'@samantha-brittany.us',
'@sanamterideal.pro',
'@santasletterss.com',
'@savethebees.pw',
'@savingnowmems.com',
'@sdbmetal.com',
'@se9bn4u-gfh.com',
'@sectionlean.pw',
'@sectionloan.pw',
'@seesee001.in',
'@seesee003.in',
'@sendspamhere.com',
'@serdijfjlzslkl.info',
'@serinfjkguty.info',
'@seriotutyron.info',
'@sgr3vm4-7g9kbqk-c3dne6.com',
'@sharedmailbox.org',
'@sharklasers.com',
'@sherlalucktypeou.info',
'@shoebucketband.com',
'@shopstoembrace.com',
'@shotpresingt.com',
'@siltricht.info',
'@silversliming.com',
'@simpledeal.pro',
'@simplefidjng.info',
'@simulaonlinehealth.we.bs',
'@sindhivani.pro',
'@skachkov1.ru',
'@skintricksupdated.com',
'@slimgeneratr.com',
'@slingnewestonlineinfo.com',
'@slingshotnewestspecials.com',
'@sloganloan.pw',
'@smalllocaldeals.info',
'@smartmatty.com',
'@socialsoal.tech',
'@societyprotest.pw',
'@societywelcome.pw',
'@sogetthis.com',
'@soiduyruser.info',
'@soingtinhg.info',
'@solidprosper.pw',
'@somebodytimesharesell.info',
'@somendkinf.info',
'@somericulture.com',
'@somertingkl.info',
'@somingjfu.info',
'@soodonims.com',
'@soorghituer.info',
'@soundhjsj.info',
'@spam4.me', '@spamavert.com', '@spambog.com', '@spambog.de', '@spambog.ru', '@spambooger.com', '@spambox.us', '@spamgourmet.com', '@spamherelots.com', '@spamhereplease.com', '@spamhole.com', '@spamstack.net', '@spamthisplease.com', //All spam email. Should be right to put them in one line.
'@spclgame.us',
'@specialbonusnewrewards.com',
'@specialnewmemberrewards.com',
'@speedmail.cl',
'@speedster.ga',
'@splashchrstmas.com',
'@src-apps-ids.com',
'@startgiftcard.com',
'@stateen.us',
'@stealum.com',
'@steenwriter.us',
'@stevensonandwilson.info',
'@stockonlinenewupdates.com',
'@stonerfans.com',
'@stoycnar.info',
'@streamingspecialnewrewards.com',
'@streetwisemail.com',
'@student-loan-forgiveness.pw',
'@student-loan-relief.pw',
'@studenthelpers.pw',
'@studiohdone.com',
'@subeb.us',
'@success-a-trophy.us',
'@sunglassesonew.com',
'@superflashlihgst.com',
'@superkphotos.com',
'@superpotlaws.com',
'@superrito.com',
'@supersecretstuffs.com',
'@supershoppings.com',
'@superskinupdate.com',
'@superultraskshot.com',
'@supremehdphotos.com',
'@surecuredigestivetoxins.us',
'@suremail.info',
'@surprisingbodyshape.com',
'@survivallightnewspecials.com',
'@sylviehache.com',
'@t0cixkud.biz',
'@taconeflash.com',
'@tacticalpennewtools.com',
'@tafmail.com',
'@takeadvantageofpots.com',
'@tasdeg.us',
'@tbwremai.com',
'@tccuracao.com',
'@tebat.us',
'@techzznews.com',
'@tedswoodworkers.us',
'@tedsworker.us',
'@teetee001.in',
'@teewars.org',
'@teleworm.us',
'@tender-forym.ru',
'@tepap.us',
'@teremerideal.pro',
'@teresaplusmaria.us',
'@tevlas6-nrc.com',
'@thealtopharma.com',
'@thebulkshopper.com',
'@thechristmasnow.com',
'@thechunkyover.com',
'@theconsultor.com',
'@thefamousgrass.com',
'@thehdfloor.com',
'@thehealthpharma.com',
'@thehighlands.co.uk',
'@theholidaysoffers.com',
'@theholydaysnews.com',
'@theimagesinhd.com',
'@theincomepostreport.com',
'@theinstowarms.com',
'@themacone.com',
'@themajorshops.com',
'@themaximumreviews.com',
'@themoleminator.com',
'@themonsterpots.com',
'@themoviescoming.com',
'@thenewesstgadget.com',
'@thenewgarcinia.com',
'@thepanshops.com',
'@thepotsecret.com',
'@thepotup.com',
'@thesantasgift.com',
'@theschannel.com',
'@theshopplaza.com',
'@thesmartslim.com',
'@thetenews.com',
'@thisisnotmyrealemail.com',
'@throwawayemailaddress.com',
'@tianxiachayuan.com',
'@tibak.us',
'@ticonderoganertim.info',
'@tinelister.us',
'@titlelf.us',
'@tltmails.info',
'@toanmytq.com',
'@tofitnessnow.com',
'@tolifepharmacy.com',
'@tomsmail.info',
'@tonebroider.us',
'@topequity.info',
'@toptrendingstories.co',
'@torchesonline.info',
'@tradermail.info',
'@tradpromos.in',
'@translatedivorce.pw',
'@translatekid.pw',
'@trbvm.com',
'@trendinghdcam.com',
'@troducather.com',
'@tromal.com',
'@trophy-and-bet.us',
'@trouserexplain.pw',
'@tss-metal.com',
'@tsuyama-jyutaku.com',
'@turof.us',
'@tyhghfnt.ru',
'@tylerthing.com',
'@uasboots.info',
'@uaslas003.in',
'@ubootshop.info',
'@ueviced.us',
'@ufs6auh-tlb.com',
'@ugmpnctc.com',
'@uhvalzwy.ru',
'@ujiaks.com',
'@uk4jdlf-ncg.com',
'@unfairenhance.pw',
'@unfairghost.pw',
'@unknowngadgets.com',
'@unlockhiipps.us',
'@untielf.us',
'@updatesecuritycoperative.ru',
'@usanewsplace.us',
'@usauto.co',
'@usefulslimtricks.com',
'@usesfulldevices.com',
'@uvdeijnh.com',
'@uz5igcb-uus.com',
'@vacances-au-top.fr',
'@vafou.us',
'@value-mycar.co.uk',
'@veryrealemail.com',
'@vesnatex-com.ru',
'@veterinarencenter.com',
'@vezek.us',
'@vgnbf8x-jgf.com',
'@victoriaplusamanda.us',
'@vijfuyrue.info',
'@vinjyutye.info',
'@viostertine.us',
'@viretesfdre.info',
'@vishulbs.ru',
'@visibleprotest.pw',
'@visionsys.us',
'@vizyonarsivi.com',
'@vmylxxcl.com',
'@voipuc.us',
'@vouytinghir.info',
'@vps11w002.com',
'@vuk95h1-svs.com',
'@walmyshop.com',
'@waterleek.us',
'@wealess.com',
'@webinarvirtualization.net',
'@webtelstra.pw',
'@weewee003.in',
'@weihongpenshaji.com',
'@weinfhyrt.info',
'@weninkogn.info',
'@werindkingh.info',
'@wezbox.com',
'@wh-holidays.com',
'@whoisdomains.org',
'@whythemoney.com',
'@wi7n386-epk.com',
'@wintervacationtrips.co',
'@workleadery.info',
'@worldnewsnetwork.co',
'@woudio.us',
'@wpr2e65-vno.com',
'@wuvia.us',
'@www-copyrus-bests-ru.ru',
'@wwwcas.info',
'@wx5nze9-npw.com',
'@xinmailnet.com',
'@xjj369.com',
'@xmkyyz.com',
'@xn--80acw4bb8ad.xn--p1ai',
'@xn--80ari1bt9b.xn--p1ai',
'@xn--90ambs9axw.xn--p1ai',
'@xn--b1aac6c1a.xn--p1ai',
'@xn--c1aihy9a.xn--p1ai',
'@xn--c1aodob4b8b.xn--p1ai',
'@xw0oz2f-bil.com',
'@y0utd1w-dbl.com',
'@yamahea.com',
'@yfyvvs7-zf8.com',
'@ykpogdwm.com',
'@yoneticiasistanligi.info',
'@yoopiweb.com',
'@yopmail.com',
'@your-local-news.co',
'@yourcardwaiting.com',
'@yourcareelement.ru',
'@yourfantasyup.com',
'@yourfavorite.info',
'@yourfittenbody.com',
'@youronlinesale.ru',
'@yoursurvivaltoolspecials.com',
'@yourvotenewonlineupdates.com',
'@yoyoaoao004.in',
'@yyaagacu.ru',
'@z-baidu.com',
'@zefferesh.com',
'@zesuu.us',
'@zihaw.us',
'@zippymail.info',
'@zoazicp-obm.com',
'@zodag.us',
'@zozoyoyo002.in',
'@zozoyoyo004.in',
'@zvdzmnfj.ru',
'@zxcvbnm.co.uk',
'@zyk6fly-qac.com',
'@zyrqehpq.ru',
];