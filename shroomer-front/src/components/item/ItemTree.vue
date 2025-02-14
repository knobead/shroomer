<script setup lang="ts">
import {onBeforeMount, watch} from "vue";
import ItemSporocarp from "@/components/item/ItemSporocarp.vue";

const props = defineProps({
  tree: {
    genus: {type: String, required: true},
    id: {type: Number, required: true},
  }
})

const empty = { genus: 'empty'}
const pied = { genus: 'pied'}
let used_template = ''

watch(() => props.tree, () => {
  refresh()
})

const templates: string[] = [
  '              z zzZzzzz                                     \n' +
  '           ZZz ZZzzZZzZzZZzz                                \n' +
  '          zZZzzzzzzZZzzZzzZ zzz                             \n' +
  '       zzZZZ ZZzZ/zZzzZzZzzzZ Z                             \n' +
  '      z  zzZzZZzz|ZzzzzzZZ/Z_ZzzzZ                          \n' +
  '     ZZZz  ZzZzZzZzZ ZZz/Z  Zzz   ZZ             zz         \n' +
  '  zzZZzZzZzzzzZ|zZz\\/||Z     Z      Z            z Z_zZ     \n' +
  '     zzZZzZzz Z |Z  \\|z      z                \\/_ZZz zZZzz  \n' +
  'zZzZz|ZZzzzzzzz  /  |                      //\\  z    Zzz  z \n' +
  '  z z   zZZz\\\\    || /       Z       ______   __Z___ zzZZZ  \n' +
  ' z z    z  Zz |___||__\\            |_          z    _    Z  \n' +
  'Z  z    Z         |    |\\        /                          \n' +
  '  z               /      \\\\     \\                           \n' +
  '                  |        \\/||                             \n' +
  '                  |         |\\                              \n' +
  '                  ||        /|                              \n' +
  '                    \\\\      ||                              \n' +
  '                     \\\\    ||                               \n' +
  '                       \\\\  ||                               \n' +
  '                        \\\\ ||                               \n' +
  '                          \\\\|                               \n' +
  '                          |||                               \n' +
  '                          |\\|                               \n' +
  '                           /\\|                              \n' +
  '                           |/|                              \n' +
  '                            |||                             \n' +
  '                            |||                             \n' +
  '                            |||                             \n',
  '           zzzzz                                            \n' +
  '          Zzzzzz\\ ZZz   Z                                   \n' +
  '         zz  ZZz \\ZzZ  ZZ                                   \n' +
  '        z   ZzZ   ZZzZZZZZzzZ             zZ                \n' +
  '        Z  Z z     zz  \\ZzZZ ZZ          ZzZZ               \n' +
  '       Z  Z       ZZzz zZz zZ            z ZzZ              \n' +
  '          z Z    z z |z/ z z z Z        ZZzZ| zzz           \n' +
  '            z   z  Z ZZ   z   z z       z  zzzzZzZz         \n' +
  '         z          ZZ||  Z            z  zz|zz/ Z Z        \n' +
  '           z   Z     Z|z              z  ZZ||zzZzZzZz       \n' +
  '                    Z  |/  z          ZZzzzZ|Z   Z Zzzz     \n' +
  '                    Z  z|\\            zZzZ|/Z     ZZzzZz    \n' +
  '                    z    /\\z         Z  z \\|z    | zZ   z   \n' +
  '                          \\\\\\       Z  z ||ZZzzZ|  Z z   z  \n' +
  '                   Zz       \\|\\     Z   |\\ Z   |ZZ    Z     \n' +
  '                              \\\\/  z  zz//\\z /|zzZz ZZZZ  z \n' +
  '                               |\\\\    |Z| |Z/ZZzZzZZZzZZ    \n' +
  '                                |\\\\\\ ||//__Z_zz|_Z z   zZz  \n' +
  '                                /||||/\\/// zz      Z        \n' +
  '                                |/||///          Z      Z Z \n' +
  '                               |||||/     zz     zZ Z       \n' +
  '                               ||\\|\\     Z                  \n' +
  '                               /|||              zz z       \n' +
  '                              ||||                          \n' +
  '                              ||/|                          \n' +
  '                              ||||                          \n' +
  '                             ||||                           \n',


  '                Zz            zzZZ                          \n' +
  '             zzZzz           |ZzZZZ                         \n' +
  '           zZZZZ||        zZzz/   zZZ                       \n' +
  'ZZ_zzz_\\\\___|__zzz|      z zzzzz ZzzzZ                      \n' +
  ' Z\\___zz/______/\\ZZ|    z  z zZZ\\Z   z                      \n' +
  'z       Z  Z  ZZz\\ZZ|  z  Zzz   Z/    z                     \n' +
  'z        Zz   Z \\|z|Z\\\\   Z    z ||         zzZ             \n' +
  '        Z Z   z   |Z|z\\\\\\/     z  \\|/ZZZzZzZ   z            \n' +
  '          z  zz    z \\\\/\\\\\\\\   z ZZZZZZz/// ZZ  Z           \n' +
  '         z  Z      Z z \\\\/\\\\|   Z|z/ZZzz      ZzZ           \n' +
  '             Z       Z  z|//|  Z/\\/|/ZZzzZ      z           \n' +
  '           Z       Z      ||||z//Z    z   Z                 \n' +
  '                      Z   |/||||       Z   z     Z          \n' +
  '                   z      \\|/|z|       Z                    \n' +
  '                           \\|||        z    Z     Z         \n' +
  '                           ||/|              Z              \n' +
  '                           ||||         Z                   \n' +
  '                            |||\\                            \n' +
  '                            |/||        Z                     \n' +
  '                            |||\\                            \n' +
  '                            |||\\                            \n',


  '                                                            \n' +
  '                                                            \n' +
  '                ZZ                                          \n' +
  '              zzZZz z                                       \n' +
  '            ZZ Z zzZzZzzZ zZZ                               \n' +
  '           z  zZZZZzzZzZzZZzZZ                              \n' +
  '            ZZzZZzZZzZzZZZzzZ Zz                            \n' +
  '          ZzzzzZzzZzzzzz  ZZ zZ Z                           \n' +
  '        Z|Z ZZZZ|/  ZZZZZ  ZZzz  Z                          \n' +
  '    zzZzzzZ Z zzZZzzZZZZzZ zZ                               \n' +
  '   ZzzZZzzzZZz|Z\\ ZZZ  z/zz  Zz   z                         \n' +
  '   ZzZzZ z|zzZ|ZZZz_/z__\\_    z                             \n' +
  '     zzzz z ZZ|ZzzZZZz z zZ\\|Z          z  Z                \n' +
  '      Z  zzZZZzzZZZZZzzZ  |/   Z/\\_____zZzZZ                \n' +
  'Zz    zzz z  ZzzZ zzZZZ   zz /Z/       zzzZZzzzzzzZ         \n' +
  'zzZZZzZZz    zzZz\\  zz Z  |//         ZZZZzZz\\zzZZ Z        \n' +
  'z zZZZZzZ  zZ  zZ|\\\\ zzzZ ||         z z          z z       \n' +
  'zZ Z\\z ZZZ  z     |\\\\\\\\Z|ZzZzZ       Zz           zz Z      \n' +
  'Z ZZZZZ__zZ Z  z//|_|_\\\\\\\\|zz zz    Zz             Zz       \n' +
  'Z_ZzzZ z  _|/___  |    \\//\\\\ z                   zZZz       \n' +
  ' zz   zz   z     |        \\\\| Z Z  Zz           Z\\\\Zz       \n' +
  ' Zz     Z      //z         |\\| z Z        ______Z_/ZzzZzzzZ \n' +
  'Zz       Z Z//ZzZ ZzZ       |//Z        _\\/____|  zZZZZzZz  \n' +
  'z          /ZzZzZ    z       |/|z     //__       Z zZzZzzzz \n' +
  ' z        z ZZZZZz    z       ||||   //\\         Z zZ zZZz  \n' +
  'Z           zZzZzzZ    Z      |||| ///          Z Z  zzZZ|_z\n' +
  ' Z          Zz Z   z          ||||\\//            Z zZZZZz   \n' +
  '            Zz zZZZ           |/////            z zZzZzZzZZ \n' +
  '             z    zz         ||//\\               z zZzZzz   \n' +
  '            Z   ZZ           |//\\              Z  z z ZZZZZ \n' +
  '             Z     Zz        ||||               Z  Z  Z zzZ \n' +
  '            z   zz           /|/|                ZZ     z   \n' +
  '             z               |||/               z Z  zz Z z \n' +
  '                             ||||                    z Zz    \n',


  '                zZZ   Z                                     \n' +
  '           ZzZZZ ZZzzzzzzzZZ                                \n' +
  '   ZZ ZzzZ ZzZZzzZzZ\\Zz/zzZZzZzz                            \n' +
  '  z ZzzZzzzzZzzZZZZZZ/zz\\z Zz\\zzZZZ      ZZzZ               \n' +
  'ZZz zZZZzz  ZzZzZzZZZZ\\Zz z zZ\\z  Z     zZ  ZZzzZZzzzz      \n' +
  'zZzzzzz|_\\_ |ZzzzzZZ  z| Z   Z Z             zzZ  zZ z      \n' +
  '    ZzZz   |/ZzZ  Z Zz  z|   |z Z           Z z|\\ZZZz       \n' +
  '      ZzZ   |ZZZ    ZZ   Z |_|//Z             Z/ZzzZZZ      \n' +
  '       Zzz  Z/Z_z_   |   |/   zZZzZ\\zZzZz       Z ZZ zzZ    \n' +
  '            zz  Z ____\\\\/|   Z   zzzZ         Z/z|ZzzzZz    \n' +
  '                      /\\\\|\\      ZZ  Z       \\   z Z ZzZz   \n' +
  '                        \\\\||/    z   _z\\_____   Z    z   z  \n' +
  '                           \\\\\\\\    /_ Z    /__\\___ZZzz    z \n' +
  '                             /\\\\ Z/\\        ZZZzzzZZzzZzzZ Z\n' +
  '                             |||//      zZZZZz___z   Z    Z \n' +
  '                             |||/      Zzz  Z ZzzZ          \n' +
  '                             ///      z     z   ZZ          \n' +
  '                             \\||       z    z   z z         \n' +
  '                             |\\|            z   z           \n',


  '                   zzZzZZZZzzz                              \n' +
  '                 ZzZZzzZZZZZZZ            ZZzzz ZZz         \n' +
  '        Z      zZZzz\\zzzzZ            ZzZ zzzZZZ            \n' +
  '    ZZzZZzZz  Zz zZz_z z_ z    ZzZZ  ZzzzZZZzzZzzZZZz       \n' +
  '   zzz ZZ|zzzzZZZzzZz   z| z_|//zZ ZZz     zZ/zzZzZZZ Zz    \n' +
  '     zZZ Z///zZZz zz     |/ Z  ZzzZZzZZZ     ZzZ ZZ|Z ZzZZZ \n' +
  '    zzz z \\    ZzzZ Z\\  |     zZzzzZ zZ      Z|_zZZ zZzz ZzZ\n' +
  '   z   Z  |           \\|     Z zzzzZ   z     \\Zz  ZZZzzZzzzz\n' +
  '    Z     |       Z   |     Z  zz   z       |    zzZZzZzZzZ \n' +
  '            /         |       Z Z   z    _\\||___Z_/Z Z ZZZzz\n' +
  '              \\/      |              |/\\_        Z\\Z  Z Z Z \n' +
  '                _/\\|\\\\/\\           |\\              Z Zzz  z \n' +
  '                      _\\/\\        ||            ZZZzZZzz  z \n' +
  '                        \\||\\     ||            z  ZZz       \n' +
  '                          \\\\|\\  \\|             ZZZzz ZZZ    \n' +
  '                            \\\\||              z  Zzz    z   \n' +
  '                             |\\|             z  zz z     Z  \n' +
  '                             |||                Z z         \n' +
  '                             |//                 ZZ         \n' +
  '                             |\\|                            \n' +
  '                             /||                            \n',


  '                ZzZzzzzZ  Z                                 \n' +
  '                z ZzzZZZZZ ZZ                               \n' +
  '                 ZZZZzzzz                                   \n' +
  '         z      Z Zz \\ zZZ                                  \n' +
  '         z  ZZ  zz z \\  ZZz            z                    \n' +
  '         zzzZZ zzzzZ |  Z  Z          ZZzZ                  \n' +
  '       zzzZZzZZzZzzZ  |  Z   __    ZZ_Zz  z                 \n' +
  '      zZ zZz zzZ z z   |  |/// _/zzzZ ZZZZ        ZzZ       \n' +
  '     z   zZZ zzZ  z z   |/       Zz ZzZZz zZ     ZzzzZ|ZZZZZ\n' +
  '          |   z Z  Z    |       zZzZZZZzZz       zzZZZzzz   \n' +
  '         ZZ\\z   z      |        Zzzz Zzzzzz/__   z /z|\\ZzZZz\n' +
  'ZZ zZz       |         \\        Z Zz_z_ZZ     __Z//z   zzzZz\n' +
  'zZZzZZzz    ///\\__//___\\       z  |Z z  Zz         Z  zZ zz \n' +
  'Z z\\__ZZ_\\//           \\/        z|Z  z           Z \\ZZzzZzz\n' +
  '   Z    |                \\\\     ||               zzzzzzzz   \n' +
  '   Z z Z|                  \\\\  ||              ZZzzz|z z zZ \n' +
  ' Zzz ZZzzz                  \\/||              z   z z  Z    \n' +
  'z  Zz/Z   zz                 |\\/                   z   z    \n' +
  '      ZZ                     |||                       Z    \n' +
  '       z                     \\||                            \n' +
  '       zz                    |||                            \n' +
  '        Z                    |||                            \n',


  '            Z               zZ  ZzZz ZZ                     \n' +
  '            z zZZzzZZz   ZZZzzZzZZZZzzzZZ      zZ           \n' +
  '            zzzzzzzZ Zz zzzzzzZzZZzz          zZZzZ         \n' +
  '          zZz zZZzzz  zZZ ZzZzzzzZz        ZzzZZZzz         \n' +
  '          Z Z /ZZ   Z    zZ|zZ zz|Z     __ZzZZZ/zZZZz       \n' +
  '         z z  Z  Z  Z |\\ZZZzzzZZ /z    |  zZZZZZZzZZzZ      \n' +
  '         z   Z||\\    Z Z zz  Z zz Z   |  ZZZzZZZZzz Z       \n' +
  '           Z     \\\\ |   ZZ   z  ZZZ \\ |      Z Zz Z  z      \n' +
  '                   \\            Z    |\\   z z     z         \n' +
  '                    |           zZ Z /         zz           \n' +
  '                    /                |                      \n' +
  '                    |                 |                     \n' +
  '                    |\\\\             /\\|____/__\\             \n' +
  '                     \\\\|//       /////                       \n' +
  '                       \\|\\|\\   |////                        \n' +
  '                          /\\\\|///                           \n' +
  '                            \\/\\                             \n' +
  '                            |||                             \n' +
  '                            \\|\\|\n',

  '                                                            \n' +
  '                                                            \n' +
  '                       z                                    \n' +
  '                     ZzZZz zZzz       zzZZZ zZ              \n' +
  '       zzzZ    Z     zz ZzzzzZZZzz   Zz zZzZ Zz             \n' +
  '   zZzZzZzZZ   zzZZzZ __ZzZZzZZzZ Z zzZzzZZZzZzZz           \n' +
  '  ZZZz Zz zzzZzzzZzzZ/zZzzZZzZzZzZ z _Z_zzZZZ   Z           \n' +
  ' ZZzZzZzZz_zzZzzzZZ\\ZZZzZZZZZzZZZZZ /   zzzzzz   Z          \n' +
  '  zzZ   zzzzzz zZzz ZzzZ\\ZZzzz zZzz/ ZZzZzz ZzZ             \n' +
  '    zZzzz Zz ZZzz |ZZzz\\   Z\\ Z  Zz/zz ZzZZzzZZZ            \n' +
  '   ZZZZz__/|Zz__\\z|ZZZZZ\\/\\zZ_/__\\ zzzZZZ/zZZ ZZZ           \n' +
  ' Z/ZzZZzz  Zz zzZ__zZZzZzZ|Z_ZZ \\/Zz\\zZ\\/_zZZzZZzZ          \n' +
  ' ZZz  z ZZZZ  zZZ z|zzZ| /Z  Z    z|z| Z ZZZZz zZ        __ \n' +
  '  ZzZ  Z    Zz    zz|ZZ/z  z     ZZz Z\\ZZzZZZ/Z z________ Z \n' +
  '  z z           ZZ  Z|/ zZZ     zZZzzZZZzZZzZ z       |  zz \n' +
  '        z       Z zZz/|    z  zZ  z  zzZ/ZZzz  Z Z    \\Zz   \n' +
  '               Z  Z Z\\|    zZZ   Z  ZzZZzz  z  zz  zz ZZ    \n' +
  '                 Z z\\|      Zz  Z   Z Zz|ZZZZ ZZZZZzzzzZ    \n' +
  '                  ZZ||        Z    ZZ  ZZ Z  Z   zzzZZZZZ   \n' +
  '                 Z  |/       Z        Z|| z_zZ|_z|Z zzzZ Z  \n' +
  '                  z\\||            Z   ZzZ__z___z/ZZZ__Z\\Z   \n' +
  '                    \\\\\\              \\|_\\zz   Z  Z   Z Z_   \n' +
  '                      /\\\\          //|Z z    z   Z     Z    \n' +
  '                       \\\\\\       ///            Z  z        \n' +
  '                         \\|\\    /|\\          z  Z  ZZzZ     \n' +
  '                          \\\\\\ ///            ZZZzZzzZZ      \n' +
  '                            \\|\\|            Z zZ  zzzzZ     \n' +
  '                            //||                            \n' +
  '                            |||\\                            \n' +
  '                            ||\\|                            \n' +
  '                            \\|\\|                            \n' +
  '                            ||\\|                            ',


  '                                                            \n' +
  '                                                            \n' +
  '                                     z                      \n' +
  '                    Z z            zZZZZZzZZ                \n' +
  '                   ZzZzZZz       zzzzzZzzzz  Z              \n' +
  '                 ZZZZzzZz  zZ zZ ZzZZZZzzZzZ ZZZzz          \n' +
  '                zzZZzZzZzZzZZZzZ zzZzZZzzzzZZZZzZzZ         \n' +
  '              ZzzZZZZzzZzZzzzzzZZZ ZZz ZZZ_ zzZZzzZzz       \n' +
  '             ZzZzZZzzzzZzzZzzzZZZ   \\Z/     ZzZzzzzzZ       \n' +
  '          zZzzzZZzzzZzzzzzzZzZZZz  Z\\zZ    //|zZZZzZZ       \n' +
  '    ZzZZzzZZZZZZzzzzzZzzzzzZzzZz   zz zzZ|/_\\zZzzZZZZzZ     \n' +
  '       ZzzZzZZZZZZ|ZZZz Z Z  z     |/zZZz    zZzZzzZZzZ     \n' +
  '     ZzZzZ/__|__z|\\ZZZZZ  Z       // zZ ZZ    zZZzzZ  Z     \n' +
  '      z Zz zZzZZZz\\\\ ZzZ        /              ZZ  Z        \n' +
  '        ZZ Z z   ZZ/\\z |zZZ   |/                            \n' +
  '                Z Z ZzZZ\\     |/                            \n' +
  '               z  zz  Z z\\   ||                             \n' +
  '                     Z  Z//  |\\                             \n' +
  '                          || ||                             \n' +
  '                           |||                              \n' +
  '                            |||                             \n' +
  '                            |||                             \n' +
  '                            |||                             \n' +
  '                            |||                             \n' +
  '                            |||                             \n' +
  '                             ||\\                            \n',

  '                                                            \n' +
  '                                                            \n' +
  '                              Zz ZZz                        \n' +
  '                           zZzZzzZZzZz zZZzZ                \n' +
  '                            zZzZZzZzZZzzzZzZzZZ             \n' +
  '                             ZzzZZZZZZzZZzZzz               \n' +
  '             zzzZ Z Zz       ZZZzZzz|zZZZzZ ZZzz            \n' +
  '      z zzZzZZZZzzZzZzZ z|zZZzzZZZZzz\\zzZzzzZZZZzZ          \n' +
  '       ZzZZZzzzZzzZzZzZZZzZZzzzzZzzZzzzzZzzzZzzZzzZZ        \n' +
  '      ZZZzZ\\ZzZzzZzzzzzzZz_zzzzzzZzzz||Zz_zZzzzZzzZz        \n' +
  '     Z ZzzZzzZz_zZ_Z|zZZZZzZz/\\zZzZzZ|Z|ZzZzzZZzZZzzZ       \n' +
  '      Zzz zZZ Zz ZZZ/zzzZzzzzzZ\\ZZZz|/zZzZZzzzzz|zZzz       \n' +
  '            z       |\\\\ZZ  zZzzz\\|zz|zZZzZz|Z//ZzZZZzZ      \n' +
  '                     z\\|    z  z |zZ/zzzZz//_zzz_ZZzzZzZz   \n' +
  '                       /        Z|Z|/ZzZZ|ZZzz/_ZzZzzZ  z   \n' +
  '                       |          //Zz|/_\\_/__zZZZZZZzZZ    \n' +
  '                        \\        ||/||__Z zZ ZzzzZzZZZ      \n' +
  '                        \\/      ///  /      Z zZZzZZZ       \n' +
  '                         ||    |||  /       ZZ zz   z       \n' +
  '                          ||  |\\ |/|                        \n' +
  '                           |||\\|||                          \n' +
  '                            ||/|||                          \n' +
  '                             |/||                           \n' +
  '                             /|\\                            \n' +
  '                             |||                           \n',

  '                                                            \n' +
  '                 zZZz zzZ                                   \n' +
  '                 ZzZZZZZzZZZzZZz                            \n' +
  '     zzZZZZZzzz ZzZZz|ZZZzzzZZZzZZZ                         \n' +
  ' ZZZZzZZzZZZzZzzzZzZzZ|zzZZZZzZZZzZZ                        \n' +
  '    ZZ_ZzZZZZZzZzZZzZzzZzzZZZzZzzzZZ                        \n' +
  '   ZZZZzZz_/_ZzzzZZzzzz ZZzzzZ zzzZzzzZ                     \n' +
  '   Z  ZzZZzzZ\\z\\\\Zz z |_Z  zZz_zZZzZ                        \n' +
  '        Zz z     \\| z /   Z zZ                              \n' +
  '         Z         |\\ |     \\                               \n' +
  '                     \\\\|     |     /____|_|__               \n' +
  '                       ||    |   /\\       zZzzz             \n' +
  '                        \\     |\\/        Z   ZZz      ____|Z\n' +
  '                         |    |/              zZ    /|zz_ZZz\n' +
  '                          || ||                  |//z\\zZZzzZ\n' +
  '                           |\\|                /_/    zZzzZZz\n' +
  '                           |||              //        z    z\n' +
  '                            |/            //                \n' +
  '                            |\\          //                  \n' +
  '                             ||      ///                    \n' +
  '                             /|     //                      \n' +
  '                             |||   //                       \n' +
  '                             ||| \\/                         \n' +
  '                             |/|/\\                          \n' +
  '                             ||//                           \n' +
  '                             //|                            \n' +
  '                             \\||                            \n' +
  '                             /||                            \n' +
  '                             |||                            \n',


  '                                                            \n' +
  '                          zz                                \n' +
  '                    ZZ/ZzzzzZ                               \n' +
  '                  zzzZzZZZZzzzzzZ                           \n' +
  '               \\ZZZZZzzZ\\ZzzzZZzZ  zZ                       \n' +
  '              zzZzZzZzZZ|zzzZzzzZZzZZZz                     \n' +
  '             ZZz  Z\\zzzzZZZZzzzzZZZZZzZZzzz                 \n' +
  '            z z  z Z\\ZZZZzZZzzZzzzZZZZzZzzzz                \n' +
  '            z z zZZZZzZ/ZZZZzZZzzzzzzZZZZzZzZZ              \n' +
  '              zZ zzzZZzz/zZzzzzzZzZzZZzZzZzZZzz             \n' +
  '                Zz ZZzzZZZZZZZzzzz|ZzzzZ_zZZzzZzz           \n' +
  '                z zZzzzz|ZzzZZZZzZ/zzzZZzz_Z/zzzzZ          \n' +
  '                    z  Z \\zzZzz|z/zZzzzzZZzzzZzzzzz         \n' +
  '                       zZz\\zZzz\\\\zZZzzZZzZzZzZZzZZzzz       \n' +
  '                            \\ZZ|ZZZ/ZZzzzZzzZZzzZz          \n' +
  '                             \\||ZzZ|ZzzZzZZZzzZZz           \n' +
  '                             ||/ZzZ|ZZzzzzz zZzzzz          \n' +
  '                             \\||   zZZzZ| z_Z_zz ZZzZ       \n' +
  '                              ||  z zZ|/|/Z  zZzZZZ  zz     \n' +
  '                              ||    Z |z  Z ZZZzz Z         \n' +
  '                               /|  /|/     zZ Z  Z Z        \n' +
  '                               |\\ |\\      ZZ  z  z  z       \n' +
  '                               ||||          z    Z         \n' +
  '                               |\\|/                         \n' +
  '                              ||||                          \n' +
  '                              |\\|                           \n' +
  '                              |||                           \n' +
  '                              |||                           \n' +
  '                             |||                            \n',


  '                                                            \n' +
  '                                      Z                     \n' +
  '            zzZZzzZzZZ ZzzzZZZZz      Z|zZ ZzzZ             \n' +
  '          ZzZzzZzZZZZZZZZzZZZzzzz|zZzZzZZZzZZ Zzz           \n' +
  '    ZzzZZzzZzZz\\zZZZ Z|zZZzZZZzzZ|ZZzzzZZ/zzZzZz            \n' +
  '  zzZzzZZZzzZ  |Z ZzZZz//zZZZzZz |ZZzzZ/ZZZ  ZZzzZZz        \n' +
  ' Z zzzZzzzzZzz||ZZ ZZ| Z/zZZZZ Zz|ZzZZz/\\ZzZZZ/ZzZZzZ       \n' +
  '  zZzZZzZz__zZZ|zz ZZ z Z ZZ Z zzzzZz_Zzzzzz  zZzZzZzZZZZz  \n' +
  ' Zz Z  zZ_zzZ z\\zZ| z|   ZZ   z|Z ZZzzZZZ    _zZZZZ  zZZz   \n' +
  '   Z  zZZZzzzz  \\ |/\\|    z//|  ZzZz/Zz  zz/_ ZZz z|\\zZz Z  \n' +
  '      z ZZ zz z   \\ ||    |       Z|Zz \\/ Zz  Zz      Zzzz  \n' +
  '     Zz  z ZZZ    |   /  |         |ZZ/    z  zZZ      zz Z \n' +
  '     ZZ   Z       |    ||          |Z      zz           Z   \n' +
  '                   |   \\|          |                     z  \n' +
  '                   |    \\         |                         \n' +
  '                     |  \\        /                          \n' +
  '                      \\ |       \\                           \n' +
  '                       \\|     |/                            \n' +
  '                        |/    |\\                            \n' +
  '                         ||  ||                             \n' +
  '                         ||  |\\                             \n' +
  '                          /| |\\                             \n' +
  '                           |||/                             \n' +
  '                            /|                              \n' +
  '                            |||                             \n' +
  '                            |||                             \n' +
  '                            |\\|                             \n' +
  '                            \\|\\                             \n' +
  '                            |||                             \n' +
  '                             |||                            \n' +
  '                             |||                           \n',


  '                                                            \n' +
  '                                                            \n' +
  '                             zZ zz                          \n' +
  '                             ZzzzzzzZz                      \n' +
  '                 Z Z   ZZ  ZZZzz\\zZZzZzz                    \n' +
  '      ZzzZzZz   zZzZzZZzZzzzzzz zzZZzZZzzZ                  \n' +
  '      ZZZZzzzzzZzzzZzZZZz\\zZzzZZZzzzZzZzzzZz                \n' +
  ' zzZZZZzZzZzzzzZ_ZzzZzZzzzz\\zZzzzZz|ZzZZzzZZz               \n' +
  'z  zZzzZzzzZz zzzz\\ZzZzzZZzzz/zZzzZZzZZzzZZZZzZ             \n' +
  'z z\\ZzzzZZZZZz____|ZzzZZZzzZ|ZzZzZzzzzzzZzZZZzzZZ           \n' +
  'zZZZZzzz_ZZzzzzZz|ZZzZzZZZZzZ|zZZZZZZZzZzzZzZZZzZ           \n' +
  'ZzZZzZZz//\\/\\z\\\\_ZZZzZ/__ZzZZZz/ZzZzzZZzzZzZzZzzZZZ         \n' +
  'zZzZzZZzzzzZZZz|_Z\\|ZZzZZZzZ //ZzzzzzZzZZZzzzzZZ Z Z        \n' +
  'Zzz|z|ZZZZZZzzZzzZzz|\\\\ZzzzzZ|\\ZzzzzzzZzZZzzzZzZZZzZz       \n' +
  'zZ Z|zZZ z    zZ  Zz   \\|ZZ | /z_zZzzzZzzzzZzzzZzzz z       \n' +
  'zZzZzZZz           zZz  ||  /\\ |ZzzZZZzzzZzzzZZzzzzz        \n' +
  'ZZZZZ                    |\\|    ZZzzzzZzzzZzzzzz z Z        \n' +
  'zzzZ zz                    ||  zzz zzzzzzzZ_ZzzZzzZZZ       \n' +
  ' z Z                        ||  z| Z/|ZzZzZZzZZ\\zZzZzZ      \n' +
  ' Z Z                         ||Z||/Z     ZzZ   zzzzz  z     \n' +
  'Z  z                         ||\\/ z      z     z   Zzz      \n' +
  'z                            |//|             z     ZzZ     \n' +
  '                             |||                     ZZ     \n' +
  '                             |||              Z             \n' +
  '                             |||                            \n' +
  '                             \\|\\                            \n' +
  '                             |||                           \n',

  '                                                            \n' +
  '                                                            \n' +
  '                                                            \n' +
  '                           z   Zzz Z                        \n' +
  '                       Z   ZzZZ zZZzzzzZ     ZZz            \n' +
  '           ZZ     z  ZZ zZzZzzZZ zzzZzzzZzz zZzZZZ          \n' +
  '         ZZzZZZzzZ z  ZZzZz|zZzZzZzZZ\\zZZZ/__zZZzZz         \n' +
  '        zz  zzzZZzzzZzZzzzZZzZzZZzzZzzz//\\ZZZZz ZZZz   Z    \n' +
  'zz        Zz ZzZ|\\ZZZzzzzZZzzzzzZZZZz|/zZzzZzzZz Zzzzzzzzz  \n' +
  'zzz    zZZZ  ZZZZzZZzZZZzzzzzzzZZZzz_|ZZZZzzZZzzZZZ/zZZ   Z \n' +
  'ZzZZ zzzzZz zzZZ|z|zzzZzzzZzzZZzzzz_ZzZzZZZZzZzzzZZz Zz     \n' +
  '|zz/ZZzZzz ZzzZzZzzzzzZz ZzZZzZZZ/ZzzzzzZZzZzZ zzZZzz z     \n' +
  '\\ZZZzZZZZzZzZZzzzzzzZzZZZZzzzzZZZzZZZzZzZZzzzzZZz ZzZzZ     \n' +
  '|zZZzZzZZZ\\zz|ZZZ__ZZzzzzzzzz\\ZzZZ\\|ZZZZzzzZZZzzZzZzZzzz    \n' +
  '|Zz\\ZzZZZzZ\\||zZZzzzZZZZ/ZzZz|zzZz|/ZzzZZ_zZ/zZZZ_zzZzZzz   \n' +
  '|ZzZZ\\\\z\\_Zz \\|ZZzzzZ| zzZZzZz|ZZZz/z_Zz|Z//zzZZzZZZzzzZzZ  \n' +
  '\\zzZ\\zzZz_\\_/Z|zz zZ Z\\\\Z|ZzZ |ZZ/Z_\\___|Zz_z_ZZZzZzzz Z z  \n' +
  '||\\_Z    zz||_|\\_  Z  ZZ|zzZ   Z/__zZz/  zzZ__zzzZZzzz    Z \n' +
  '||__\\_\\_|/\\\\z||Z ____  |  z    |/z|z/\\_/zzZzzzZzzZZZ ZZ     \n' +
  '|ZZz_______\\\\\\||    /\\ |     /__\\_\\\\   zzzZZZzZZZzZZz  z    \n' +
  '/zzZ      /\\\\\\\\|\\     \\/    /_    | /_/\\zZzZ\\zzzzzZzzz      \n' +
  '|  z        |\\\\\\||\\\\   /|  \\/|    |\\    z|ZZzzZzZzzZzz      \n' +
  '|   z         \\\\\\\\|/\\\\\\  \\\\\\|/   //   _ZZzZZZzZZzZZzz       \n' +
  '|                |\\\\\\\\\\\\\\ \\\\|   /_//ZZz_\\zZzZZZzZZzzzzZ     \n' +
  '                    \\\\\\\\\\||\\\\ /__  z    ZZzZ_zzzzzzZZZ z    \n' +
  '                       \\\\|||///       zZzZZZzzZZzzZZ  z     \n' +
  '                        |||//         zZ  Z ZZzZzzZzZ Z     \n' +
  '                        ||/\\|        zz   z ZzZzZzZZ        \n' +
  '                         /|\\|        Z    Z Zz zzz          \n' +
  '                         ||/|             ZzZ Z zz          \n' +
  '                          ||\\\\                              \n' +
  '                          \\|/|                              \n' +
  '                           ||/|                             \n' +
  '                           ||||                            \n',

]

function refresh() {
  used_template = templates[props.tree.id % templates.length]

  used_template = used_template.replaceAll('/', "<span class='text-amber-700'>/</span>")
  used_template = used_template.replaceAll('|', "<span class='text-amber-800'>|</span>")
  used_template = used_template.replaceAll('\\', "<span class='text-amber-900'>\\</span>")
  used_template = used_template.replaceAll('_', "<span class='text-amber-800'>_</span>")

  let searchOne = 'z'
  let searchTwo = 'Z'

  if (props.tree.age % 2 == 0) {
    searchOne = 'Z'
    searchTwo = 'z'
  }

  console.log(props.tree.age)

  if (props.tree.genus.includes('fraxinus')) {
    used_template = used_template.replaceAll(searchOne, "<span class='text-green-800 font-bold'>f</span>")
    used_template = used_template.replaceAll(searchTwo, "<span class='text-green-700 font-bold'>F</span>")
  }

  if (props.tree.genus.includes('quercus')) {
    used_template = used_template.replaceAll(searchOne, "<span class='text-green-800 font-bold'>Q</span>")
    used_template = used_template.replaceAll(searchTwo, "<span class='text-green-700 font-bold'>q</span>")
  }

  if (props.tree.genus.includes('castanea')) {
    used_template = used_template.replaceAll(searchOne, "<span class='text-green-800 font-bold'>C</span>")
    used_template = used_template.replaceAll(searchTwo, "<span class='text-green-700 font-bold'>c</span>")
  }

  if (props.tree.genus.includes('pinus')) {
    used_template = used_template.replaceAll(searchOne, "<span class='text-green-800 font-bold'>p</span>")
    used_template = used_template.replaceAll(searchTwo, "<span class='text-green-700 font-bold'>P</span>")
  }
}

onBeforeMount(() => {
  refresh()
})
</script>

<template>
  <div class="inline-block" v-if="props.tree.slot == 0" >
    <pre class="text-gray-200" v-html="used_template"></pre>
    <item-sporocarp :sporocarp="props.tree.slot_3"/>
    <item-sporocarp :sporocarp="props.tree.slot_1"/>
    <item-sporocarp :sporocarp="pied"/>
    <item-sporocarp :sporocarp="props.tree.slot_2"/>
    <item-sporocarp :sporocarp="props.tree.slot_4"/>
  </div>

  <div class="inline-block" v-if="props.tree.slot == 1" >
    <pre class="text-gray-200" v-html="used_template"></pre>
    <item-sporocarp :sporocarp="props.tree.slot_3"/>
    <item-sporocarp :sporocarp="props.tree.slot_1"/>
    <item-sporocarp :sporocarp="pied"/>
    <item-sporocarp :sporocarp="props.tree.slot_2"/>
    <item-sporocarp :sporocarp="props.tree.slot_4"/>
  </div>
  <div class="inline-block" v-if="props.tree.slot == 2" >
    <pre class="text-gray-200" v-html="used_template"></pre>
    <item-sporocarp :sporocarp="props.tree.slot_3"/>
    <item-sporocarp :sporocarp="props.tree.slot_1"/>
    <item-sporocarp :sporocarp="pied"/>
    <item-sporocarp :sporocarp="props.tree.slot_2"/>
    <item-sporocarp :sporocarp="props.tree.slot_4"/>
  </div>
  <div class="inline-block" v-if="props.tree.slot == 3" >
    <pre class="text-gray-200" v-html="used_template"></pre>
    <item-sporocarp :sporocarp="props.tree.slot_3"/>
    <item-sporocarp :sporocarp="props.tree.slot_1"/>
    <item-sporocarp :sporocarp="pied"/>
    <item-sporocarp :sporocarp="props.tree.slot_2"/>
    <item-sporocarp :sporocarp="props.tree.slot_4"/>
  </div>
  <div class="inline-block" v-if="props.tree.slot == 4" >
    <pre class="text-gray-200" v-html="used_template"></pre>
    <item-sporocarp :sporocarp="props.tree.slot_3"/>
    <item-sporocarp :sporocarp="props.tree.slot_1"/>
    <item-sporocarp :sporocarp="pied"/>
    <item-sporocarp :sporocarp="props.tree.slot_2"/>
    <item-sporocarp :sporocarp="props.tree.slot_4"/>
  </div>
</template>

<style>
pre {
  font-size: 9px;
}
</style>
