from __future__ import unicode_literals
from django.db import models

import json

# Create your models here.
class SalesRecord(models.Model):
	Region = models.CharField(max_length=100)
	Country = models.CharField(max_length=50)
	City = models.CharField(max_length=50)
	TotalSales = models.IntegerField()

	def __unicode__(self):
		return u'%s %s %s %s' % (self.Region, self.Country, self.City, self.TotalSales)