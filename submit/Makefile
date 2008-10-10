ifndef TOPDIR
TOPDIR=..
endif
include $(TOPDIR)/Makefile.global

ifdef CYGWIN
EXECSUFFIX = .exe
OBJSUFFIX = .cygwin.o
TARGETS = submit$(EXECSUFFIX)
else
OBJSUFFIX = .o
TARGETS = submit submitdaemon
endif

LIBSBASE = $(addprefix $(TOPDIR)/lib/,lib.error lib.misc)
LIBHEADERS = $(addsuffix .h,$(LIBSBASE))
LIBOBJECTS = $(addsuffix $(OBJSUFFIX),$(LIBSBASE))

SUBMITCOMMONOBJ = submitcommon$(OBJSUFFIX)

ifneq ($(shell which curl-config),)
LIBCURL     = $(shell curl-config --version | cut -d ' ' -f 2)
CURLLIBS    = $(shell curl-config --libs)
CURLPREFIX  = $(shell curl-config --prefix)
CURLINCLUDE = $(CURLPREFIX)/include
CURLSTATIC  = $(CURLPREFIX)/lib/libcurl.a
CURLDEF     = -DLIBCURL=$(LIBCURL)
CURLFLAGS   = $(CURLDEF) -I$(CURLINCLUDE) $(CURLLIBS)
endif

domserver: submitdaemon

submitclient: submit$(EXECSUFFIX)

build: $(TARGETS)

$(TARGETS): %$(EXECSUFFIX): %.cc $(SUBMITCOMMONOBJ) $(TOPDIR)/etc/config.h \
                            $(LIBOBJECTS) $(LIBHEADERS)
	$(CXX) $(CXXFLAGS) $(patsubst %.h,,$^) -o $@ $(CURLFLAGS)
	$(STRIP) $@

$(LIBOBJECTS):
	$(MAKE) -C $(TOPDIR)/lib $(notdir $@)

$(SUBMITCOMMONOBJ): %$(OBJSUFFIX): %.cc %.h $(LIBHEADERS)
	$(CXX) -c $(CXXFLAGS) $< -o $@

submit$(EXECSUFFIX): $(CURLSTATIC)

install-domserver:
	install -m u=rwx,go=rx -t $(domserver_bindir) submitdaemon
	install -m u=rwx,go=rx -t $(domserver_libdir) submit_copy.sh
	install -m u=rw,go=r   -t $(domserver_libdir) submit_db.php

clean:
	-rm -f $(TARGETS) $(SUBMITCOMMONOBJ)

.PHONY: