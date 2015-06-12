# Rkt_Config - Magento Extension

This Magento extension will allow us to use custom config files in Magento. Config files are XML files which are normally used
to do some configuration settings. 

By default `config.xml` file which resides in `/etc` directory in Magento modules is used to hold configurations corresponding to that module. It is not possible to use any other custom config files along with a module (Yes there exists and `adminhtml.xml` and some other XML files, but it is different). This module fills this gap. Using this module, you can create any number of config files. All of the config files are storing in DB. Depending upon either Frontend or Backend page request made, related XML files will get loaded to global configuration.
