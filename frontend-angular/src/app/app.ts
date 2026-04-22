import { ChangeDetectionStrategy, Component, computed, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { cvData } from './cv-data';

@Component({
  selector: 'app-root',
  imports: [FormsModule],
  templateUrl: './app.html',
  styleUrl: './app.scss',
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class App {
  protected readonly cv = cvData;
  protected readonly demoBadges = ['Angular standalone', 'Signals', 'Responsive UI'];
  protected readonly skillQuery = signal('');
  protected readonly filteredSkills = computed(() => {
    const query = this.skillQuery().trim().toLowerCase();

    if (!query) {
      return this.cv.skills;
    }

    return this.cv.skills.filter((skill) => {
      return (
        skill.name.toLowerCase().includes(query) ||
        skill.category.toLowerCase().includes(query)
      );
    });
  });
  protected readonly careerYears = Math.max(
    1,
    new Date().getFullYear() - this.cv.careerStartYear
  );
  protected readonly experienceCount = this.cv.experiences.length;
  protected readonly totalSkills = this.cv.skills.length;
}
