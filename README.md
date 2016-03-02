# android-sms-65-to-64-workaround

So you just updated your CyanogenMod 12.1, probably to "stable" snapshot build, and now your SMS app is crashing with error `android.database.sqlite.SQLiteException: Can't downgrade database from version 65 to 64`, you know that you can just delete `/data/data/com.android.providers.telephony/mmssms.db` file, reboot and be happy, but you can't be happy because you must save your messages? Okay, this is what I faced and here is what you can do.

  - copy your `mmssms.db` file to computer (this will be the source)
  - delete it on device, reboot and copy the newly created `mmssms.db` (this will be the destination)
  - put the names of your src and dst files in the script
  - run it (you need PHP with SQLite3 installed)
  - replace `mmssms.db` on your device with your dst file
  - reboot
  - be happy

This script just copies content of some tables from old to the new db. Feel free to improve it.

Hope this will help somebody.
