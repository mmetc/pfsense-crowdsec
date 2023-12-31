# $FreeBSD$

PORTNAME=	pfSense-pkg-crowdsec
PORTVERSION=	0.0.2
PORTREVISION=	9
CATEGORIES=	security
MASTER_SITES=	# empty
DISTFILES=	# empty
EXTRACT_ONLY=	# empty

MAINTAINER=	marco@crowdsec.net
COMMENT=	Crowdsec package for pfSense

LICENSE=	APACHE20

RUN_DEPENDS=	crowdsec>=1.5.1:security/crowdsec \
		crowdsec-firewall-bouncer:security/crowdsec-firewall-bouncer

NO_BUILD=	yes
NO_MTREE=	yes

SUB_FILES=	pkg-install pkg-deinstall
SUB_LIST=	PORTNAME=${PORTNAME}

do-extract:
	${MKDIR} ${WRKSRC}

do-install:
	${MKDIR} ${STAGEDIR}${PREFIX}/pkg
	${MKDIR} ${STAGEDIR}${PREFIX}/www/shortcuts
	${MKDIR} ${STAGEDIR}${PREFIX}/www/crowdsec/js
	${MKDIR} ${STAGEDIR}${PREFIX}/www/crowdsec/css
	${MKDIR} ${STAGEDIR}${PREFIX}/www/crowdsec/endpoint
	${MKDIR} ${STAGEDIR}/etc/inc/priv
	${MKDIR} ${STAGEDIR}${DATADIR}
	${MKDIR} ${STAGEDIR}${PREFIX}/etc/rc.conf.d/
	${MKDIR} ${STAGEDIR}${PREFIX}/etc/rc.d/
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/crowdsec.xml \
		${STAGEDIR}${PREFIX}/pkg
	${INSTALL_DATA} -m 0755 ${FILESDIR}${PREFIX}/www/crowdsec_landing.php \
    		${STAGEDIR}${PREFIX}/www
	${INSTALL_DATA} -m 0755 ${FILESDIR}${PREFIX}/www/crowdsec_status.php \
			${STAGEDIR}${PREFIX}/www
	${INSTALL_DATA} -m 0755 ${FILESDIR}${PREFIX}/www/crowdsec_metric.php \
            			${STAGEDIR}${PREFIX}/www
	${INSTALL_DATA} -m 0755 ${FILESDIR}${PREFIX}/www/crowdsec/endpoint/api.php \
          			${STAGEDIR}${PREFIX}/www/crowdsec/endpoint
	${INSTALL_DATA} -m 0755 ${FILESDIR}${PREFIX}/www/crowdsec/js/crowdsec.js \
           			${STAGEDIR}${PREFIX}/www/crowdsec/js
	${INSTALL_DATA} -m 0755 ${FILESDIR}${PREFIX}/www/crowdsec/js/jquery.bootgrid.min.js \
           			${STAGEDIR}${PREFIX}/www/crowdsec/js
	${INSTALL_DATA} -m 0755 ${FILESDIR}${PREFIX}/www/crowdsec/js/jquery.bootgrid.fa.min.js \
					${STAGEDIR}${PREFIX}/www/crowdsec/js
	${INSTALL_DATA} -m 0755 ${FILESDIR}${PREFIX}/www/crowdsec/js/moment.min.js \
					${STAGEDIR}${PREFIX}/www/crowdsec/js
	${INSTALL_DATA} -m 0755 ${FILESDIR}${PREFIX}/www/crowdsec/css/jquery.bootgrid.min.css \
				${STAGEDIR}${PREFIX}/www/crowdsec/css
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/www/shortcuts/crowdsec.inc \
			${STAGEDIR}${PREFIX}/www/shortcuts
	${INSTALL_DATA} ${FILESDIR}/etc/inc/priv/crowdsec.priv.inc \
    		${STAGEDIR}/etc/inc/priv
	${INSTALL_DATA} ${FILESDIR}${PREFIX}/pkg/crowdsec.inc \
		${STAGEDIR}${PREFIX}/pkg
	${INSTALL_DATA} ${FILESDIR}${DATADIR}/info.xml \
		${STAGEDIR}${DATADIR}

	( cd ${FILESDIR}${PREFIX}/pkg/crowdsec && \
		cp -r ./ ${STAGEDIR}${PREFIX}/pkg/crowdsec )

	${INSTALL_DATA} -m 0744 ${FILESDIR}${PREFIX}/etc/rc.conf.d/* \
		${STAGEDIR}${PREFIX}/etc/rc.conf.d/

	${INSTALL_DATA} -m 0744 ${FILESDIR}${PREFIX}/etc/rc.d/* \
		${STAGEDIR}${PREFIX}/etc/rc.d/

	@${REINPLACE_CMD} -i '' -e "s|%%PKGVERSION%%|${PKGVERSION}|" \
		${STAGEDIR}${DATADIR}/info.xml

.include <bsd.port.mk>
