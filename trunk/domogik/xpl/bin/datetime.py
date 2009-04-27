#!/usr/bin/python
# -*- encoding:utf-8 -*-

# Copyright 2008 Domogik project

# This file is part of Domogik.
# Domogik is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.

# Domogik is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with Domogik.  If not, see <http://www.gnu.org/licenses/>.

# Author: Maxence Dunnewind <maxence@dunnewind.net>

# $LastChangedBy:$
# $LastChangedDate:$
# $LastChangedRevision:$

from time import localtime
from domogik.xpl.lib.xplconnector import *
from domogik.common.configloader import *
import time
import signal


class xPLDateTime(xPLModule):
    '''
    Send date and time on the xPL network every minute
    '''

    def __init__(self):
        xPLModule.__init__(self)
        self.__myxpl = Manager(module_name='datetime')
        #TODO: Set it to 60 seconds instead of 10
        self._timer = xPLTimer(10, self._send_datetime, self.get_stop())
        self.register_timer(self._timer)
        self._timer.start()
        signal.pause()

    def _f(self, nb):
        '''
        Format the number
        '''
        if int(nb) < 10:
            return "0%s" % nb
        else:
            return nb

    def _send_datetime(self):
        '''
        Send date and time on xPL network
        '''
        dt = localtime()
        date = "%s%s%s" % (dt[0], self._f(dt[1]), self._f(dt[2]))
        time = "%s%s%s" % (self._f(dt[3]), self._f(dt[4]), self._f(dt[5]))
        datetime = "%s%s" % (date, time)
        datetimedaynumber = "%s%s" % (datetime, dt[6])
        mess = Message()
        mess.set_type("xpl-trig")
        mess.set_schema("datetime.basic")
        mess.set_data_key("date", date)
        mess.set_data_key("time", time)
        mess.set_data_key("datetime", datetime)
        mess.set_data_key("format1", datetimedaynumber)
        self.__myxpl.send(mess)

if __name__ == "__main__":
    xPLDateTime()
