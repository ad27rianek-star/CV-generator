import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('cvBuilder', (initial = {}) => ({
    template: initial.template ?? 'classic',
    personal: {
        first_name: '',
        last_name: '',
        title: '',
        email: '',
        phone: '',
        city: '',
        summary: '',
        ...(initial.personal ?? {}),
    },
    experience: initial.experience?.length
        ? initial.experience
        : [{ company: '', position: '', period: '', description: '' }],
    education: initial.education?.length
        ? initial.education
        : [{ school: '', field: '', period: '' }],
    skillsInput: (initial.skills ?? []).join(', '),
    get skills() {
        return this.skillsInput.split(',').map((s) => s.trim()).filter(Boolean);
    },
    addExperience() {
        this.experience.push({ company: '', position: '', period: '', description: '' });
    },
    removeExperience(index) {
        this.experience.splice(index, 1);
    },
    addEducation() {
        this.education.push({ school: '', field: '', period: '' });
    },
    removeEducation(index) {
        this.education.splice(index, 1);
    },
}));

Alpine.start();
