# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Advanced use:
  # yarrs('Yarrs.yaml', config) do |hostname, settings|
  # end

  # Regular use:
  yarrs('Yarrs.yaml', config)
config.vm.provider :virtualbox do |vb|
  vb.gui = true
end
  # config.push.define "staging", strategy: "ftp" do |push|
      # Login Credentials
      # push.host = "104.131.206.241"
      # push.username = "root"
      # push.password = "root"

      # FTP vs SFTP
      # push.secure = "true"

      # Where to copy the files on the server
      # push.destination = "/var/www/"

      # Where are App is
      # push.dir = "./"
  # end
end