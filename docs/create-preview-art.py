from pathlib import Path
import math,random
random.seed(12)
P=Path(__file__).resolve().parents[1] / 'public' / 'media'
def scene(name,bg,leaf,linen,arch):
 s=[f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1600 1000"><rect width="1600" height="1000" fill="{bg}"/><defs><pattern id="grain" width="7" height="7" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r=".6" fill="#fff" opacity=".1"/><circle cx="5" cy="6" r=".5" fill="#321915" opacity=".08"/></pattern><g id="branch"><path d="M0 0Q-20-110 20-230" fill="none" stroke="#9fa17a" stroke-width="3"/>']
 for i in range(9):
  y=-20-i*24; x=8*math.sin(i)
  s.append(f'<ellipse cx="{x-22}" cy="{y-9}" rx="29" ry="9" transform="rotate(35 {x-22} {y-9})" fill="{leaf}"/><ellipse cx="{x+20}" cy="{y-22}" rx="27" ry="8" transform="rotate(-35 {x+20} {y-22})" fill="{leaf}"/>')
 s+=['</g><g id="flower">']
 for angle in range(0,360,60):
  s.append(f'<ellipse cx="0" cy="-12" rx="11" ry="17" transform="rotate({angle})" fill="#efc6bd" stroke="#c69d93" stroke-width=".7"/>')
 s+=['<circle r="6" fill="#b98d51"/></g></defs>']
 # garden landscape, lightly hatched mountain silhouettes
 s.append(f'<path d="M0 370Q220 160 420 370T830 320T1250 345T1600 280V1000H0Z" fill="{leaf}" opacity=".4"/>')
 for x in range(-100,1800,130):
  s.append(f'<path d="M{x} 650Q{x-60} 400 {x+20} 170Q{x+110} 385 {x+90} 650" fill="{leaf}" opacity=".38"/>')
 s.append('<path d="M0 720Q800 620 1600 720V1000H0Z" fill="#b8a38a"/>')
 # Structure, curtains and arch; intentionally graphic, no claim of photography
 s.append(f'<path d="M140 100L800 30L1460 100L1300 310H300Z" fill="{linen}" stroke="#c8b59d" stroke-width="2"/><path d="M800 30L350 310M800 30L550 310M800 30L800 310M800 30L1040 310M800 30L1260 310" fill="none" stroke="#cabba5" stroke-width="2"/>')
 s.append(f'<path d="M140 100Q290 370 170 800L335 800Q250 400 300 310Z" fill="{linen}"/><path d="M1460 100Q1310 370 1430 800L1265 800Q1350 400 1300 310Z" fill="{linen}"/>')
 s.append('<path d="M170 160Q250 350 200 720M1430 160Q1350 350 1400 720" fill="none" stroke="#c8b59d" stroke-width="3"/>')
 s.append(f'<path d="M580 690V430A220 220 0 0 1 1020 430V690" fill="{arch}" stroke="#c8b59d" stroke-width="3"/><path d="M620 690V440A180 180 0 0 1 980 440V690" fill="none" stroke="#f7e5ca" stroke-width="2"/>')
 # Decorative hanging pendants
 for x,y in [(460,360),(800,320),(1140,360)]:
  s.append(f'<path d="M{x} 140V{y}" stroke="#9b774c" stroke-width="2"/><ellipse cx="{x}" cy="{y+25}" rx="28" ry="37" fill="#e7c58d" stroke="#9b774c" stroke-width="2"/><path d="M{x} {y-12}V{y+62}" stroke="#b08d56"/>')
 # Reception table and chairs
 for side in [-1,1]:
  for i in range(5):
   x=800+side*(190+i*39); y=640+i*60
   s.append(f'<g transform="translate({x} {y})"><path d="M-32 0V-55Q0-90 32-55V0M-32-10H32M-26 0L-32 60M26 0L32 60" fill="none" stroke="#654b34" stroke-width="5"/><path d="M-32-3H32L38 15H-38Z" fill="#c6ac80"/></g>')
 s.append(f'<path d="M685 585H915L1100 1000H500Z" fill="{linen}" stroke="#c5b5a1" stroke-width="2"/><path d="M770 585H830L900 1000H700Z" fill="#dfb2a6" opacity=".6"/>')
 for i in range(5):
  y=620+i*75; delta=100+i*25
  for side in [-1,1]:
   x=800+side*delta
   s.append(f'<ellipse cx="{x}" cy="{y}" rx="{20+i*4}" ry="{8+i}" fill="#f9f0de" stroke="#bb9a62" stroke-width="1.5"/><path d="M{x+side*35} {y-20}V{y-2}M{x+side*28} {y-2}H{x+side*42}" stroke="#907b61" fill="none"/><ellipse cx="{x+side*35}" cy="{y-25}" rx="8" ry="10" fill="none" stroke="#907b61"/>')
  s.append(f'<path d="M800 {y}V{y-60}" stroke="#a28451" stroke-width="3"/><path d="M797 {y-60}V{y-85}H803V{y-60}" fill="#fff4cf"/>')
  for j in range(3):
   s.append(f'<use href="#flower" x="{780+j*19}" y="{y+15+(j%2)*9}" transform="rotate({j*25} {780+j*19} {y+15})"/>')
 # foreground framing leaves and flowers
 for side in [-1,1]:
  base=0 if side==-1 else 1600
  for j in range(16):
   x=base-side*random.randrange(0,190); y=1100-random.randrange(0,150); a=side*random.randrange(10,65)
   s.append(f'<use href="#branch" transform="translate({x} {y}) rotate({a}) scale({random.uniform(1,2):.2f})"/>')
  for j in range(15):
   x=base-side*random.randrange(0,230);y=random.randrange(760,1040)
   s.append(f'<use href="#flower" transform="translate({x} {y}) scale({random.uniform(.8,1.8):.2f})"/>')
 s.append('<rect width="1600" height="1000" fill="url(#grain)"/></svg>')
 (P/name).write_text(''.join(s))
scene('garden-preview.svg','#86917a','#485c42','#e7d9bf','#c1b19a')
scene('intimate-preview.svg','#a38069','#5b6246','#edd9c2','#8a6453')
scene('reception-preview.svg','#777060','#3d4b3a','#e3d0ba','#aa8e78')
