<script setup lang="ts">
defineProps({
  tree: Object,
})
</script>

<template>
<pre v-if="tree.genus=='fraxinus'">
    .ffFFfFF.
  #FFfFFfffFfFF
 FFFF\FF.FFffF#ff
  FfFFfFfFYFF/FFF
   fFf\ \/`/FfF
    FF\  /FF
      | ;|
      |  |
      | ;|
      |  |
      |. |
_/_\_/ .  \;_.\_
</pre>
<pre v-else-if="tree.genus=='castanea'">
    .CccCcCC.
  CCCCcCCcCCCCC
 CCCC\CC.CccCCCcC
 CCCCcCC.CccCcCCC
  CCcCCcCcYCC/CCC
   CcC\ \/`/CCC
    CC\   /CC
      |  ;|
      |   |
      |  ;|
      |   |
      |   |
      |.  |
_/_\_/ .   \;_.\_
</pre>
<pre v-else-if="tree.genus=='quercus'">
    .CccGcCC.
  CCGCcCCcGGcCC
 CCCC\CC.CggCCCcC
 CCC\ \C.\c/ /Ccc
  CGc\ \CcY  /CcC
   CcC\ \/`/GCG
    CC\   /CC
      |   |
      |   |
      |.  |
_/_\_/ .   \;_.\_
</pre>
<pre v-else-if="tree.genus=='pinus'">
       PP
      ppGP
      p/Gp
    .PppGpP
    GP;P;pGG
   pGPpPP/P;
   P;P| |GG;
  PPGP|.|ppp
  ppGP| |GGpp
 PPPP\P\  \gPPPpP
 pp   | . |    ``P
      | | |
      |. ;|
_/_\_/ .   \;_.\_
</pre>
</template>

<style>
</style>
