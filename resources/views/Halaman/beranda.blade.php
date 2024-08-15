import numpy as np

# a. Pembentukan himpunan Fuzzy

def membership_waktu(x):
    cepat = max(min((5 - x) / 5, 1), 0)
    sedang = max(min((x - 3) / 2, (10 - x) / 2, 1), 0)
    lama = max(min((x - 8) / 7, 1), 0)
    return {'cepat': cepat, 'sedang': sedang, 'lama': lama}

def membership_sampah(x):
    return {'terdeteksi': 1 if x == 1 else 0, 'tidak_terdeteksi': 1 if x == 0 else 0}

def membership_air(x):
    rendah = max(min((3 - x) / 3, 1), 0)
    tinggi = max(min((x - 4) / (100 - 4), 1), 0)  # Assuming max height is 100 cm
    return {'rendah': rendah, 'tinggi': tinggi}

def membership_tempat_sampah(tinggi, volume):
    # Simplified membership function for tempat sampah
    if tinggi <= 50 and volume <= 50:  # Assuming 50 as midpoint
        return 'rendah'
    else:
        return 'tinggi'

# b. Komposisi Aturan Fuzzy

def apply_rules(waktu, sampah, air, tempat_sampah):
    rules = [
        ('cepat', 'terdeteksi', 'rendah', 'rendah', 'OFF'),
        ('sedang', 'terdeteksi', 'rendah', 'rendah', 'OFF'),
        ('lama', 'terdeteksi', 'rendah', 'rendah', 'OFF'),
        ('cepat', 'tidak_terdeteksi', 'rendah', 'rendah', 'OFF'),
        ('sedang', 'tidak_terdeteksi', 'rendah', 'rendah', 'OFF'),
        ('lama', 'tidak_terdeteksi', 'rendah', 'rendah', 'OFF'),
        ('cepat', 'terdeteksi', 'tinggi', 'tinggi', 'OFF'),
        ('sedang', 'terdeteksi', 'tinggi', 'tinggi', 'OFF'),
        ('lama', 'terdeteksi', 'tinggi', 'tinggi', 'OFF'),
        ('cepat', 'tidak_terdeteksi', 'tinggi', 'tinggi', 'OFF'),
        ('sedang', 'tidak_terdeteksi', 'tinggi', 'tinggi', 'OFF'),
        ('lama', 'tidak_terdeteksi', 'tinggi', 'tinggi', 'OFF'),
        ('cepat', 'terdeteksi', 'tinggi', 'rendah', 'ON'),
        ('sedang', 'terdeteksi', 'tinggi', 'rendah', 'ON'),
        ('lama', 'terdeteksi', 'tinggi', 'rendah', 'OFF')
    ]
    
    waktu_fuzzy = membership_waktu(waktu)
    sampah_fuzzy = membership_sampah(sampah)
    air_fuzzy = membership_air(air)
    
    output = []
    for rule in rules:
        w, s, a, t, result = rule
        strength = min(waktu_fuzzy[w], sampah_fuzzy[s], air_fuzzy[a])
        if t == tempat_sampah:
            output.append((strength, result))
    
    return output

# c. Defuzzifikasi (metode Sugeno)

def defuzzify(rule_outputs):
    on_strength = sum(strength for strength, result in rule_outputs if result == 'ON')
    off_strength = sum(strength for strength, result in rule_outputs if result == 'OFF')
    
    if on_strength > off_strength:
        return 'ON'
    else:
        return 'OFF'

# Main function to process inputs and get the fuzzy output

def fuzzy_conveyor_control(waktu, sampah, air, tinggi_sampah, volume_sampah):
    tempat_sampah = membership_tempat_sampah(tinggi_sampah, volume_sampah)
    rule_outputs = apply_rules(waktu, sampah, air, tempat_sampah)
    result = defuzzify(rule_outputs)
    return result

# Example usage:
waktu = 4  # seconds
sampah = 1  # terdeteksi
air = 5  # cm
tinggi_sampah = 40  # assuming units
volume_sampah = 30  # assuming units

result = fuzzy_conveyor_control(waktu, sampah, air, tinggi_sampah, volume_sampah)
print(f"Conveyor should be: {result}")