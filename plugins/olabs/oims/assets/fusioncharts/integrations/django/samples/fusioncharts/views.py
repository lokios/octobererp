from django.shortcuts import render

# it is a default view.
# please go to the samples folder for others view

def catalogue(request):
 	return  render(request, 'catalogue.html')