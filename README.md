# Templex Engine

***I Tried To Create This mini Template engine Framework in order to simulate Warp framework in joomla  v4.X , the most used classes are the helpers there is about Tens of them ,so i had a project and i recreated only about 5 class helpers that i needed, the helpers object instances are stored in global array indexs as you know: those i upgraded are the following.***
- [x] $this['config']
- [x] $this['path']
- [x] $this['template']
- [x] $this['widgets']
- [ ] $this['assets']
- [x] $this['system']

> but i did'nt make a global instance  assets   => $this['assets'], so you have to load your assets files and assets , feel fee fork my project and scaling up this feature



 
 ## File architecture
 
 **the file structure following MVC arch and Complying with j4**

1 src/
  - Controller
  - Helper
  - Config
 
 
**to include file in your project just include templex.php in your project and make in instance of templex class and call the render method of template to render the entry file which is located in /layouts same level with templex.php , you can also edit src/Helper/ConfigHelper.php as you want to return the settings that are savec in src/Config/config.json**


 
